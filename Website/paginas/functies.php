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
		echo $e->getMessage();

	}
}

function hotItems()
{
	return query("SELECT titel, beschrijving, bodBedrag
				FROM tblVoorwerp v
				inner join (select voorwerpNummer, max(bodBedrag) AS bodBedrag
				FROM tblBod
				group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
				where v.voorwerpNummer in(select top 2 voorwerpNummer
				from tblBod
				group by voorwerpNummer
				order by count(voorwerpnummer) desc)");
}

//Index.php -> Select statement voor uitgelichteitems
function featuredItems()
{
  	return query("SELECT titel, beschrijving, b.bodBedrag
  				from tblVoorwerp v
  				inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
  							from tblBod
  							group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
                where v.voorwerpNummer in (select top 5 v.voorwerpNummer
  											from tblVoorwerp v
  											inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
  														from tblBod
														group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
  				order by startPrijs/bodBedrag*100 desc)");
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

function items($search)
{
  $search = "%".$search."%";
	if($search != "%%"){
		return preparedQuery("SELECT titel, beschrijving, b.bodBedrag, startPrijs
					from tblVoorwerp v
					full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
					from tblBod
					group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
					inner join tblVoorwerpRubriek vr on v.voorwerpNummer= vr.voorwerpNummer
					inner join tblRubriek r on vr.rubriekNummer=r.rubriekNummer
					where r.rubriekNaam like :rubriekname",["rubriekname"=>$search]);
	} else {
		return query("SELECT titel, beschrijving, b.bodBedrag, startPrijs, v.voorwerpNummer
					from tblVoorwerp v
					full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
					from tblBod
					group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer");
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
		$sql = "insert into tblGebruiker(gebruikersNaam,voornaam,achternaam,adresRegel,extraAdresRegel,postcode,plaatsNaam,land,geboorteDag,mail,wachtwoord,vraagNummer,antwoordvraag,mogelijkeVerkoper) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$query = $dbh->prepare($sql);


		$query->execute(array($RegistrationForm['userName'], $RegistrationForm['voornaam'], $RegistrationForm['achternaam'], $RegistrationForm['adres'], $RegistrationForm['adresExtra'], $RegistrationForm['postcode'], $RegistrationForm['plaatsnaam'], $RegistrationForm['land'],"08-08-1996", $RegistrationForm['mail'], $RegistrationForm['password'],
							  $RegistrationForm['geheimevraag'],$RegistrationForm['antwoordvraag'],"0"));





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

return preparedQuery("SELECT commentaar, dag,tijd, titel ,feedbackSoort from tblFeedback , tblVoorwerp  where tblvoorwerp.voorwerpNummer = tblFeedback.voorwerpNummer AND  verkoper = :verkoper",["verkoper" =>$verkoper]);

}


function getseller($itemID)
{
  	return preparedQuery(" SELECT verkoper, lidSinds, succesvolleVerkopen
                          FROM tblVerkoper, tblVoorwerp
                          WHERE tblverkoper.gebruikersnaam = tblvoorwerp.verkoper and tblvoorwerp.voorwerpNummer = :voorwerpNummer",["voorwerpNummer" =>$itemID]);
}


// Vragen uit database halen
function getQuestions(){

return query("select * from tblVraag");

}

"SELECT c.rubriekNaam, c.rubriekNummer, p.rubriekNaam as parentNaam
from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
order by rubriekNaam asc"
 ?>
