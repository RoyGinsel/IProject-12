<?php
include "database.php";
include "../../SQLSrvConnect.php";

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
return query("SELECT titel,beschrijving,startPrijs FROM tblVoorwerp");
}

//Index.php -> Select statement voor uitgelichteitems
function uitgelichteitems()
{
  return query("SELECT titel,beschrijving,startPrijs FROM tblVoorwerp");

}

function rubrieken()
{
  return query("SELECT titel,beschrijving,startPrijs FROM tblRubriek");
}

 ?>
