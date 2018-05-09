<?php include 'includes/rubrieken-zoeken.php'; ?>

<!-- search -->
<div class="uk-margin-remove">
   <!-- php pagina met rubrieken -->
   <form class="uk-search uk-search-default uk-flex-inline" autocomplete="off" action="Producten.php" method="get">
     <div class="autocomplete">
       <input id="myInput" class="uk-search-input" name="rubriek" type="search" placeholder="Zoek op rubrieken">
     </div>
     <div class="uk-float-right ">
       <input class="" type="submit">
     </div>
   </form>
</div>

<div class="uk-padding-remove uk-height-large uk-overflow-auto uk-flex  uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2">
  <?php
  include "includes/Rubrieken-accordion.php"
?>

</div>
