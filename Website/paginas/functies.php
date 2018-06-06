<?php
    include "database.php";
	//include "../../SQLSrvConnect.php";


function query($stringquery)
{
	try{
    	global $dbh;
    	$sql = $stringquery;
    	$query = $dbh->prepare($sql);
    	$query->execute();
    	return $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
}

function preparedQuery($stringquery,$parameters)
{
	try{
		global $dbh;
		$query = $dbh->prepare($stringquery);
		$query->execute($parameters);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
	}
}

function preparedInsertQuery($stringquery,$parameters)
{
	try{
		global $dbh;
		$query = $dbh->prepare($stringquery);
		$query->execute($parameters);
	}
	catch(PDOException $e) {
	}
}

function preparedSPQuery($stringquery,$parameters)
{
	try{
		global $dbh;
		$query = $dbh->prepare($stringquery);
		$query->execute($parameters);
	}
	catch(PDOException $e) {
		return $e->getMessage();
	}
}

function hotItems()
{
	return query("SELECT titel, beschrijving, bodBedrag, v.voorwerpNummer
                FROM tblVoorwerp v
                inner join (select voorwerpNummer,max(bodBedrag) AS bodBedrag
                      FROM tblBod
                      GROUP BY voorwerpNummer) b ON v.voorwerpNummer=b.voorwerpNummer
                      WHERE v.voorwerpNummer IN(SELECT top 5 voorwerpNummer
                                                FROM tblBod
                                                GROUP BY voorwerpNummer
                                                ORDER BY count(voorwerpnummer) DESC)
                                                AND veilingGesloten = 0");
}

//Index.php -> Select statement voor uitgelichteitems
function featuredItems()
{
  	return query("SELECT titel, beschrijving, b.bodBedrag, v.voorwerpNummer
  				from tblVoorwerp v
  				inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
  							from tblBod
  							group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
                where v.voorwerpNummer in (select top 5 v.voorwerpNummer
  											from tblVoorwerp v
  											inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
  														from tblBod
														group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
  				order by bodBedrag/Startprijs*100 desc)
          AND veilingGesloten = 0");
}

function sections($value)
{
  	return preparedQuery("SELECT rubriekNaam, rubriekNummer
				from tblRubriek
				where parentRubriek = :rubrieknumber
				order by rubriekNaam asc", [":rubrieknumber"=>$value]);
}

function changes($date)
{
	return preparedQuery("SELECT count(*) as aantal
				from tblVoorwerp
				where  looptijdBeginDag > :date",["date"=>$date]);
}

function items($search, $filter)
{
	if($search != ""){
		return preparedQuery("SELECT titel, beschrijving, b.bodBedrag, startPrijs
					from tblVoorwerp v
					full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
					from tblBod
					group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
					inner join tblVoorwerpRubriek vr on v.voorwerpNummer= vr.voorwerpNummer
					inner join tblRubriek r on vr.rubriekNummer=r.rubriekNummer
					where veilingGesloten = 0 and
					r.rubriekNummer = :rubriekname $filter",["rubriekname"=>$search]);
	} else {
		return query("SELECT titel, beschrijving, b.bodBedrag, startPrijs, v.voorwerpNummer
					from tblVoorwerp v
					full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
					from tblBod
					group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
					where veilingGesloten = 0 $filter");
	}
}



function loop($section)
{
	echo "<ul uk-accordion>";
	foreach(sections($section) as $row){
		echo "<li class ='uk-flex'> <a class='uk-accordion-title'>
		 ".$row ['rubriekNaam']."</a> <div class='uk-accordion-content'>";
		loop($row['rubriekNummer']);
		echo "</div></li>";
	}
	echo "</ul>";
}




// kijken of de mail bestaat bij registreren.
function checkavailableMail($mail){
	return preparedQuery("select mail
						from tblGebruiker
						where mail =:mail",[":mail"=> $mail]);
}


//kijken of de gebruikersnaambestaat
function checkavailableUsername($userName){
	return preparedQuery("select GebruikersNaam
						from tblGebruiker
						where GebruikersNaam =:GebruikersNaam",[":GebruikersNaam"=> $userName]);
}


// kijken of de username voorkomt in de database
function loginCheck($username)
{
	return preparedQuery("SELECT gebruikersNaam, wachtwoord
						FROM tblGebruiker
						WHERE gebruikersNaam = :username",[":username" =>$username]);

}

function getPassword($username){
	return preparedQuery("SELECT wachtwoord
											FROM tblGebruiker
											WHERE gebruikersNaam = :username",[":username" =>$username]);
}

// registreren.
function newAccount($RegistrationForm){


	try {

		global $dbh;
		$sql = "insert into tblGebruiker(gebruikersNaam,voornaam,achternaam,adresRegel,extraAdresRegel,postcode,plaatsNaam,land,geboorteDag,mail,wachtwoord,vraagNummer,antwoordvraag,mogelijkeVerkoper,geblokkeerd) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$query = $dbh->prepare($sql);


		$query->execute(array($RegistrationForm['userName'], $RegistrationForm['voornaam'], $RegistrationForm['achternaam'], $RegistrationForm['adres'], $RegistrationForm['adresExtra'], $RegistrationForm['postcode'], $RegistrationForm['plaatsnaam'], $RegistrationForm['land'],"08-08-1996", $RegistrationForm['mail'], $RegistrationForm['password'],
							  $RegistrationForm['geheimevraag'],$RegistrationForm['antwoordvraag'],"0","0"));





	} catch (PDOException $e) {


		echo $e->getMessage();
	}

	header('location: ./index.php');
}

function getProductinfo($itemID)
{
  	return preparedQuery("SELECT *
				from tblVoorwerp
				where voorwerpNummer = :voorwerpNummer",["voorwerpNummer" =>$itemID]);
}


function getReview($verkoper){

return preparedQuery("SELECT commentaar, dag,tijd, titel ,feedbackSoort
                      FROM tblFeedback , tblVoorwerp
                      WHERE tblvoorwerp.voorwerpNummer = tblFeedback.voorwerpNummer AND  verkoper = :verkoper",["verkoper" =>$verkoper]);

}


function getseller($itemID)
{
  	return preparedQuery(" SELECT verkoper, lidSinds, succesvolleVerkopen
                          FROM tblVerkoper, tblVoorwerp
                          WHERE tblverkoper.gebruikersnaam = tblvoorwerp.verkoper and tblvoorwerp.voorwerpNummer = :voorwerpNummer",["voorwerpNummer" =>$itemID]);
}

// Functie om hoogste bod van een item te krijgen
function getHighestBid($itemID)
{
  return preparedQuery("SELECT TOP 1 MAX(bodBedrag) AS HoogsteBod
                        FROM tblBod, tblVoorwerp
                        WHERE tblBod.voorwerpNummer = tblVoorwerp.voorwerpNummer  AND tblVoorwerp.voorwerpNummer = :voorwerpNummer", ["voorwerpNummer" =>$itemID]);
}
// Functie om mogelijke verkoper te krijgen
function getSellerInfo($username)
{
  return preparedQuery("SELECT *
                        FROM tblGebruiker
                        WHERE mogelijkeVerkoper = 1 and gebruikersNaam = :GebruikersNaam",[":GebruikersNaam"=> $username]);
}

function getPossibleBuyer($username)
{
  return preparedQuery("SELECT *
                        FROM tblVerkoper
                        WHERE gebruikersNaam = :GebruikersNaam",[":GebruikersNaam"=> $username]);
}

// Vragen uit database halen
function getQuestions(){

return query("select * from tblVraag");

}

function newVoorwerpNummer(){
	return query("SELECT max(voorwerpNummer) +1 as voorwerpnummer from tblVoorwerp");
}

function addNewBid($amount, $item, $username){
	return preparedSPQuery("exec spNieuwBod :amount, :item, :username",["amount" => $amount,"item" => $item, "username" => $username]);
}
// veilingen halen
function getAuctions($seller){
	return preparedQuery("SELECT titel,looptijd , v.voorwerpNummer,looptijdBeginDag,veilingGesloten,max(bodBedrag) as bodBedrag,startPrijs,looptijdEindeDag,looptijdEindeTijdstip
	from tblVoorwerp v
	full join tblBod b on v.voorwerpNummer=b.voorwerpNummer
	where verkoper = :verkoper
	group by titel, looptijdBeginDag, startPrijs, looptijdEindeDag,looptijd,v.voorwerpNummer,veilingGesloten, looptijdEindeTijdstip",[":verkoper"=> $seller]);

}


	// tijd berekenen overgebleven dagen veiling
function format_interval(DateInterval $interval) {
	$result = "";
	if ($interval->d) { $result .= $interval->format("%d dagen "); }
	if ($interval->h) { $result .= $interval->format("%h uur "); }

	return $result;
}


// geeft allebiedingen weer voor mijnveilingen
function getAllBids($itemID){
	return preparedQuery("SELECT *
                        FROM tblBod WHERE voorwerpNummer = :itemID
                        ORDER BY bodBedrag DESC",["itemID" => $itemID]);
}


// geeft de select voor alle rubrieken weer
function allSections(){
	return Query("SELECT c.rubriekNaam, c.rubriekNummer, p.rubriekNaam as parentNaam
				from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
				order by rubriekNaam asc");
};



 ?>
