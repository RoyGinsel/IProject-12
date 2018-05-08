
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
// foreach (rubrieken() as $waarde) {
//   $hoofdrubriek = "";
//   $subrubrieken = "";
//   if($waarde['hoofdRubriek'] != $hoofdrubriek ) {
//     echo "
//     <div class='uk-padding-small uk-nav uk-dropdown-nav'>
//     <h3>".$waarde['hoofdRubriek']."</h3>
//     <ul class='uk-list uk-list-striped'>";
//   }
//   $hoofdrubriek = $waarde['hoofdRubriek'];
//   $subrubrieken.= "<li>".$waarde['subRubriek']."</li>";
//     if($waarde['hoofdRubriek'] != $hoofdrubriek){
//       echo "
//       .$subrubrieken.
//       </ul>
//       </div>";
//       }
//   }
  $hoofdRubriek = "";
  $subRubriek = "";
  $rubriek = "<div><ul>";
  foreach (rubrieken() as $waarde) {
    if($waarde['hoofdRubriek'] <> $hoofdRubriek){
      $rubriek .= "</ul></div>";
      $hoofdRubriek = $waarde['hoofdRubriek'];
      $rubriek .= "<div class='uk-padding-small uk-nav uk-dropdown-nav'>
      <h3>".$waarde['hoofdRubriek']."</h3>
      <ul class='uk-list uk-list-striped'>";
    }
    $rubriek .= "<li>".$waarde['subRubriek']."</li>";
    echo "$rubriek </ul></div>";
  }
?>

<div class="uk-padding-small uk-nav uk-dropdown-nav">
  <h3>postzegels</h3>
  <ul>
    <li>europa</li>
    <li>amerika</li>
  </ul>
</div>

<div class="uk-padding-small uk-nav uk-dropdown-nav">
  <h3>postzegels</h3>
  <ul>
    <li>europa</li>
    <li>amerika</li>
  </ul>
</div>
</div>
