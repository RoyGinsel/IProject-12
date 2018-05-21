<?php
	include "database.php";
	//include "../../SQLSrvConnect.php";
	//Index.php -> Select statement voor populaireitems

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
    	return $query->fetchAll();
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
	if($search != ""){
		return preparedQuery("SELECT titel, beschrijving, b.bodBedrag, startPrijs
					from tblVoorwerp v
					full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
					from tblBod
					group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
					inner join tblVoorwerpRubriek vr on v.voorwerpNummer= vr.voorwerpNummer
					inner join tblRubriek r on vr.rubriekNummer=r.rubriekNummer
					where r.rubriekNaam like '%:rubriekname%'",["rubriekname"=>$search]);
	} else {
		return query("SELECT titel, beschrijving, b.bodBedrag, startPrijs
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

 ?>
