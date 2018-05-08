<?php
include "database.php";
//include "../../SQLSrvConnect.php";

//Aanpassen AUB! Simon :)
//Index.php -> Select statement voor populaireitems

function query($stringquery)
{
  global $dbh;
  $sql = $stringquery;
  $query = $dbh->prepare($sql);
  $query->execute();
  return $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
}

function populaireitems()
{
return query("SELECT titel, beschrijving, b.bodBedrag
FROM tblVoorwerp v
inner join (select voorwerpNummer, max(bodBedrag) AS bodBedrag
			FROM tblBod
			group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
where v.voorwerpNummer in(select top 5 voorwerpNummer
							from tblBod
							group by voorwerpNummer
							order by count(voorwerpnummer) desc)");
}


//Index.php -> Select statement voor uitgelichteitems
function uitgelichteitems()
{
  return query("SELECT titel,beschrijving,startPrijs FROM tblVoorwerp");

}

function rubrieken()
{
}

 ?>
