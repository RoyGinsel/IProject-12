
  <script>
var rubriekClicked;
function appendText(nummer,html){
  //voeg aan een element met het id = nummer+"div" een meegegeven html toe
  $("#"+nummer + "div").append(html);
}

$(document).ready(function(){
  $('.a').one("click",function (element) {
       //bepalen van id waarop geklikt is
        rubriekClicked =  $(this).attr('id');
        //stuurt een request naar de url
        $.ajax({type: 'POST',
        //haalt de data op van de url
          url: "includes/Rubrieken-laden.php",
          //stuurt data mee, zo kan deze worden opgevangen en gebruikt worden
          data:{rubriekNewOpen: rubriekClicked} ,
          //op een succes voer de functie de html toevoegd uit
         success: function(result) {
            appendText(rubriekClicked,result);
        }});
    });
});
</script>

<div>
  <?php
    $section = "";
    foreach(sections(-1) as $value){
      //kijkt of deze rubriek een subrubriek heeft
      if(sections($value['rubriekNummer']) != NULL){
        $section .=  "<ul uk-accordion class='rubriekenlijst uk-margin-bottom'> <li> <a id='".$value['rubriekNummer']."' class='uk-accordion-title uk-text-small'>"
        .$value['rubriekNaam']."</a>  <div class='uk-accordion-content'><ul class='uk-list'>";
      } else {
          $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$value['rubriekNaam']."'>".$value['rubriekNaam']."</a></li>";
          $section .= "</ul></li></ul>";
        }
  
      foreach(sections($value['rubriekNummer'])as $sub){
        //kijkt of deze rubriek een subrubriek heeft
        if(sections($sub['rubriekNummer']) != NULL){
          $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$sub['rubriekNummer']."'class='uk-accordion-title a uk-text-small'>"
          .$sub['rubriekNaam']."</a>  <div id='".$sub['rubriekNummer']."div' class='uk-accordion-content'><ul class='uk-list'>
           </ul></li></ul>";
         }
          else {
           $section .= "<li> <a class='uk-link-reset' href='producten.php?rubriek=".$sub['rubriekNaam']."'>".$sub['rubriekNaam']."</a></li>"; 
          }
        }
        $section .= "</ul></li></ul>";
      }
  echo $section;
    
  ?>
</div>

