
<div id ="test">

<?php
include "../functies.php";
$rubriekNewOpen = $_POST['rubriekNewOpen'];

$section = "";
  foreach(sections($rubriekNewOpen) as $value){
    if(sections($value['rubriekNummer']) != NULL){
      $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$value['rubriekNummer']."' 
      class='uk-accordion-title'>"
      .$value['rubriekNaam']."</a>  <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
    } else {
        $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$value['rubriekNaam']."'>".$value['rubriekNaam']."</a></li>";
        $section .= "</ul></li></ul>";
      }

    foreach(sections($value['rubriekNummer'])as $sub){
      if(sections($sub['rubriekNummer']) != NULL){
        $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$sub['rubriekNummer']."'class='uk-accordion-title a'>"
        .$sub['rubriekNaam']."</a>  <div id='".$sub['rubriekNummer']."div' class='uk-accordion-content'><ul class='uk-list uk-list-striped'>
         </ul></li></ul>";
         $section .= "</ul></li></ul>";
       }
        else {
         $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>"; 
        }
      }
    }
echo $section;
?>
   