
  <script>
var rubriekClicked;
function appendText(nummer,html){
  $("#"+nummer + "div").append(html);
}


$(document).ready(function(){
  $('.a').click(function (element) {
       //bepalen van id warop geklikt is
        rubriekClicked =  $(this).attr('id');
        $.ajax({type: 'POST',
          url: "includes/ajax-test.php",
          data:{rubriekNewOpen: rubriekClicked} ,
         success: function(result) {
            appendText(rubriekClicked,result);
        }});
    });
});
</script>

       <div id ="test">
      <?php
  $section = "";
  foreach(sections(-1) as $value){
    $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a class='uk-accordion-title'>"
    .$value['rubriekNaam']."</a>  <div id='".$value['rubriekNummer']."'
    class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
      foreach(sections($value['rubriekNummer'])as $sub)
        $section .=  "<ul uk-accordion class='rubriekenlijst'> <li> <a id='".$sub['rubriekNummer']."' class='uk-accordion-title a' >"
        .$sub['rubriekNaam']."</a>  <div id='".$sub['rubriekNummer']."div'class='uk-accordion-content'><ul class='uk-list uk-list-striped'></ul></li></ul>";
        $section .= "</ul></li></ul>";
    }
  echo $section;
  
   ?>
      </div>
