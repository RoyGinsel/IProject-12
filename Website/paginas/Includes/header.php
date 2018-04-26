<?php
  $breadcrumb = "<li><a href='index.php'>Home</a></li>";
  foreach($crumbs as $crumb){
    $breadcrumb .= "<li><a href='$crumb.php'>$crumb</a></li>";
  }
?>
<a name="top"></a>
<header>
 <div class="uk-flex-inline uk-flex-between uk-flex-middle uk-width-1-1 header">
    <button type="button" class="uk-button uk-button-small uk-padding-remove uk-margin-small-left"><img src="../media/Hamburgermenu.png" alt=""></button>
    <div class="dropmenu" uk-dropdown>
      <ul class="uk-nav uk-dropdown-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="producten.php">Producten</a></li>
        <li><a href="product.php">Product</a></li>
      </ul>
    </div>
    <h1 class="uk-align-right uk-margin-medium-top uk-margin-small-right"><a href="index.php"> Eenmaal Andermaal</a></h1>
  </div>
  <div class="uk-width-1-1 breadcrumb uk-flex-inline uk-flex-center">
    <ul class="uk-breadcrumb ">
      <?php echo $breadcrumb; ?>
    </ul>
  </div>
 </header>