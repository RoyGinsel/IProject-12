<!-- search -->
<div class="uk-margin-remove">
   <!-- php pagina met rubrieken  en autocomplete-->
   <form class="uk-search uk-search-default uk-flex-inline"  action=producten.php method="get" class="pointer">
     <div class="autocomplete">
       <?php //autocomplete id veranderd omdat hij vaker word aangeroepen
       //id wordt gebruikt in de javascript autocomplete functie
        echo "<input id='search1' class='searchbartext uk-search-input' name='rubriek' type='text' placeholder='Zoek op rubrieken'>"; 
        ?>
      <div id="autocomplete-list"></div>
      </div>
     <div class="uk-float-right ">
       <input class="submitButton" type="submit">
     </div>
   </form>
</div>

<!-- Rubrieken accordion -->
<div class="uk-padding-remove uk-height-large uk-overflow-auto uk-flex  uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2">
  <?php
  include "includes/Rubrieken-accordion.php";
?>
</div>

<!-- Javascript -->
<script type="text/javascript">
$(document).ready(function(){
  //als er een key is ingedrukt op de id 'search1'
  $('#search1').keyup(function(){
    //input waarde opslaan in variabele
    var result = $(this).val();
    //alert(result);
    if(result != ''){
      //stuurt een request naar de url
      $.ajax({
        url: "includes/search.php",
        method: "POST",
        //speel de inputwaarde door aan de url
        data: { result:result },
        //Op succes maak de html van de data die is verkregen van de url
        success:function(data){
          $('#autocomplete-list').fadeIn();
          $('#autocomplete-list').html(data);
        }
      });
    }
  });
  
  //Als er op een list item is geklikt, geeft de input die waarde en sluit de lijst
  $(document).on('click','li',function(){
    $('#search1').val($(this).text());
    $('#autocomplete-list').fadeOut();
  });
});
</script>
