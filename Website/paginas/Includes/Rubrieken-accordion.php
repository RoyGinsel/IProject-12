<?php
  $section = "";
  foreach(sections(-1) as $value){
    $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
    .$value['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
    foreach(sections($value['rubriekNummer'])as $sub){
      $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>";
    }
  $section .= "</ul></li></ul>";
  }
  echo $section;
?>
