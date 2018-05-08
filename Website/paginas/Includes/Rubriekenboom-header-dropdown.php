
<!-- search -->
<div class="uk-margin-remove">
   <!-- php pagina met rubrieken -->
    <form class="uk-search uk-search-default" action="">
        <a href="" uk-search-icon></a>
        <input class="uk-search-input" type="search" name="search" placeholder="Search...">
    </form>
</div>

<div class="uk-padding-remove uk-height-large uk-overflow-auto uk-flex  uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2">
  <?php
  $rubriek = "";
  foreach(rubrieken(-1) as $waarde){
    $rubriek .=  "<ul uk-accordion> <li><div class='uk-padding-small uk-nav uk-dropdown-nav'> <a class='uk-accordion-title' >"
    .$waarde['rubriekNaam']."</a> <div class='uk-accordion-content'><ul class='uk-list uk-list-striped'>";
    foreach(rubrieken($waarde['rubriekNummer'])as $sub){
      $rubriek .= "<li>".$sub['rubriekNaam']."</li>";
    }
    $rubriek .= "</ul></div></div></ul>";
  }
  echo $rubriek;
?>

</div>
