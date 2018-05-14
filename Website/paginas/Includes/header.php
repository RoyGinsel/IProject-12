<?php
  $breadcrumb = "<li><a href='index.php'>Home</a></li>";
  foreach($crumbs as $crumb) {
    $breadcrumb .= "<li><a href='$crumb.php'>$crumb</a></li>";
  }

  //Cookie zetten voor callout
$cookie_name = "Callout";
$cookie_value = date("Y-m-d");
setcookie($cookie_name ,$cookie_value,time() + (86400 * 30),"/",null,null,null);
?>

<a name="top"> </a>
<header>
  <div class="uk-flex-inline uk-flex-between uk-flex-middle uk-width-1-1 header">
    <div>
      <button type="button" class="uk-button uk-button-small uk-padding-remove uk-margin-small-left"><img src="../media/Hamburgermenu.png" alt=""></button>
      <div class="dropmenu" uk-dropdown>
        <ul class="uk-nav uk-dropdown-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="producten.php">Producten</a></li>
        </ul>
      </div>
      <!-- Rubrieken dropdown medium & larger -->
      <span class="uk-visible@s">
      <button type="button" class=" rubrieken uk-button uk-button-small uk-margin-small-left uk-text-capitalize">Rubrieken</button>
      <div class=" uk-width-3-4 uk-padding-remove-left uk-padding-remove-right uk-margin-remove-left uk-margin-remove-right uk-child-width-1-3@M" uk-dropdown="mode: click" uk-grid>
        <?php 
        $id = "search1"
        include "Rubriekenboom-header-dropdown.php"?>
      </div>
    </div>
  </span>

    <h1 class="uk-align-right uk-margin-medium-top uk-margin-small-right"><a href="index.php"> Eenmaal Andermaal</a></h1>
  </div>

  <!-- Rubrieken dropdown small -->
  <span class="uk-hidden@s">
  <button type="button" class="uk-button uk-button-small uk-padding-remove uk-margin-remove uk-width-1-1 uk-margin-small-left">Rubrieken</button>
  <div class="uk-width-1-1 uk-padding-remove-left uk-padding-remove-right uk-child-width-1-3@M" uk-dropdown="mode: click" uk-grid>
      <?php
      $id = "search2" 
      include "Rubriekenboom-header-dropdown.php"?>
  </div>
  </div>
  </span>


  <div class="uk-flex uk-flex-center  uk-width-1-1 breadcrumb uk-flex-inline uk-flex-center">
    <ul class="uk-breadcrumb crumb">
      <?php echo $breadcrumb; ?>
    </ul>
  </div>
 </header>
