<?php
$rubriek = "";
foreach(rubrieken(-1) as $waarde){
  $rubriek .=  "<ul uk-accordion class='rubriek'> <li> <a class='uk-accordion-title'>"
  .$waarde['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
  foreach(rubrieken($waarde['rubriekNummer'])as $sub){
    $rubriek .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>";
  }
  $rubriek .= "</ul></li></ul>";
}
echo $rubriek;
?>
