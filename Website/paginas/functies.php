<?php
include "database.php";
//include "../../SQLSrvConnect.php";

//Aanpassen AUB! Simon :)
//Index.php -> Select statement voor populaireitems
function populaireitems()
{
  global $dbh;
  $sql = "SELECT titel,beschrijving,startPrijs FROM tblVoorwerp";
  $query = $dbh->prepare($sql);
  $query->execute();
return  $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
}

//Index.php -> Select statement voor uitgelichteitems
function uitgelichteitems()
{
  global $dbh;
  $sql = "SELECT titel,beschrijving,startPrijs FROM tblVoorwerp";
  $query = $dbh->prepare($sql);
  $query->execute();
return  $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
}

 ?>
