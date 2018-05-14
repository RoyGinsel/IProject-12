<?php
$rubriek = "";
foreach(rubrieken(-1) as $waarde){
  //hoofdrubriek
  $rubriek .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
  .$waarde['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
  //sub-items toevoegen
  foreach(rubrieken($waarde['rubriekNummer'])as $sub){
    $rubriek .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>";
  }
  //sluiten
  $rubriek .= "</ul></li></ul>";
}
echo $rubriek;
?>
