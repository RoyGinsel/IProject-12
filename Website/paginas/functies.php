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
		$e->getMessage();
		exit("you broke it numbskull");
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
  return query("SELECT rubriekNaam, rubriekNummer
								from tblRubriek
								where parentRubriek = $value
								order by rubriekNaam asc");
}

function changes($date)
{
	return query("SELECT count(*) as aantal
				from tblVoorwerp
				where  looptijdBeginDag > '$date'");
}

function items($search)
{
	if($search != ""){
	return query("SELECT titel, beschrijving, b.bodBedrag, startPrijs
				from tblVoorwerp v
				full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
							from tblBod
							group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
				inner join tblVoorwerpRubriek vr on v.voorwerpNummer= vr.voorwerpNummer
				inner join tblRubriek r on vr.rubriekNummer=r.rubriekNummer
				where r.rubriekNaam like '%$search%'");
	} else {
		return query("SELECT titel, beschrijving, b.bodBedrag, startPrijs
				from tblVoorwerp v
				full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
							from tblBod
							group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer");
	}
}

 ?>
