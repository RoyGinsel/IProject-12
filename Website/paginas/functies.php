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
return query("select titel, beschrijving, b.bodBedrag
from tblVoorwerp v
inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
			from tblBod
			group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
where v.voorwerpNummer in(select top 2 voorwerpNummer
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
  return query("SELECT * FROM tblRubriek where parentRubriek = -1");
}

 ?>
