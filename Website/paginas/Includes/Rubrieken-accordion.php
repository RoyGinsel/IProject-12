<?php
//   $section = "";
//   $parentrubriek= -1;
//   while(sections($parentrubriek) != NULL){
//   foreach(sections($parentrubriek) as $value) {
//     $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
//     .$value['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
//        $parentrubriek = $value['rubriekNummer'];
//        foreach(sections($value['rubriekNummer'])as $sub){
//          $section .=  "<li><ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
//          .$value['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'></li>";
//   }
//   // $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>";
// $section .= "</ul></li></ul>";
// }
// echo $section;
// }
?>


<?php
$parentrubriek= -1;
  $section = "";
  foreach(sections($parentrubriek) as $value){
    $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
    .$value['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
    foreach(sections($value['rubriekNummer']) as $sub){
      if((sections($parentrubriek) != NULL)){
        $parentRubriek = $sub['RubriekNummer'];
        $section .= "<li><div class='uk-accordion-content'><ul uk-accordion><li> </li>";
      }
      else{
       $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>";
    }
  $section .= "</ul></li></ul>";
  }
  echo $section;
?>
