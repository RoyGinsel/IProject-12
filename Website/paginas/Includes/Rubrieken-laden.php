   
<?php
include "../functies.php";
//Opgevangen variabele van de ajax request op rubrieken-accordion.php
$rubriekNewOpen = $_POST['rubriekNewOpen'];

$section = "";

  foreach(sections($rubriekNewOpen) as $value){
    if(sections($value['rubriekNummer']) != NULL){
      $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$value['rubriekNummer']."' 
      class='uk-accordion-title uk-text-small'>"
      .$value['rubriekNaam']."</a>  <div class='uk-accordion-content'><ul class='uk-list'>";
    } else {
        $section .= "<li> <a class='uk-link-reset uk-text-small' href='producten.php?rubriek=".$value['rubriekNummer']."'>".$value['rubriekNaam']."</a></li>";
        $section .= "</ul></li></ul>";
      }

    foreach(sections($value['rubriekNummer'])as $sub){
      if(sections($sub['rubriekNummer']) != NULL){
        $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$sub['rubriekNummer']."'class='uk-accordion-title a uk-text-small'>"
        .$sub['rubriekNaam']."</a>  <div id='".$sub['rubriekNummer']."div' class='uk-accordion-content'><ul class='uk-list'>
         </ul></li></ul>";
       }
        else {
         $section .= "<li> <a class='uk-link-reset uk-text-small' href='producten.php?rubriek=".$sub['rubriekNummer']."'>".$sub['rubriekNaam']."</a></li>"; 
        }
      }
      $section .= "</ul></li></ul>";
    }
echo $section;
?>
   