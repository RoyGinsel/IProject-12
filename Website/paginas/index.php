<?php
session_start();
  //include('..\SQLSrvConnect.php');
$cookie_name = "test";
if(!isset($_COOKIE[$cookie_name])){
    setcookie($cookie_name ,"1",time() + (86400 * 30),"/",null,null,null);
}
 ?>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TEST</title>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

   <!-- * Alert message (voor eerste bezoekers) -->


  <header class="uk-nav-header">
    <nav class="uk-navbar-container" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-navbar-toggle uk-logo uk-invisible-large" href="#">Logo</a>
        <ul class="uk-navbar-nav">
          <li class="uk-hidden-touch">
            <a href="#">
                    <span class="uk-icon uk-margin-small-right" uk-icon="icon: star"></span>
                    Features
                </a>
          </li>
        </ul>

        <nav class="uk-navbar-container uk-margin uk-hidden-touch" uk-navbar>
          <div class="uk-navbar-item">
            <div>Some <a href="#">Link</a></div>
          </div>
          <div class="uk-navbar-item uk-hidden-touch">
            <form action="javascript:void(0)">
              <input class="uk-input uk-form-width-small" type="text" placeholder="Input">
              <button class="uk-button uk-button-default">Button</button>
            </form>
          </div>
      </div>
      <div class="uk-navbar-right uk-margin-right">
        <a href="#offcanvas-slide" class="uk-button uk-button-default uk-hidden-notouch" uk-toggle>Menu</a>
        <div class="uk-inline uk-hidden-touch">
          <button class="uk-button uk-button-default" type="button">Menu</button>
          <div uk-dropdown>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</div>
        </div>
      </div>
      </nav>

      <div id="offcanvas-slide" uk-offcanvas>
        <div class="uk-offcanvas-bar">

          <ul class="uk-nav uk-nav-default">
            <li class="uk-active"><a href="#">Active</a></li>
            <li><a href="#">Item</a></li>
            <li class="uk-nav-header">Header</li>
            <li><a href="#">Item</a></li>
            <li><a href="#">Item</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="#">Item</a></li>
          </ul>

        </div>
      </div>
      </div>
    </nav>
  </header>
  <?php


if(!isset($_COOKIE[$cookie_name])) {
    echo  '
    <>
    <div class="welkom-melding" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <h1> Welkom op de website!</h1>
        <p> Veel koop plezier </p> </div>';
}
    ?>
  <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m uk-width-1-1">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1" uk-grid>
      <div class="uk-card uk-card-default uk-width-1-4">
        <img src="https://media.production.coolgift.com/product/Chocolat-Game-Controller-1.jpg" alt="">
      </div>
      <div class="uk-card uk-card-default uk-width-1-4">
        <p>Omschrijvinga aslkdfjaljfioera; uiiiiiiiiiiii iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii jksdnhfuisdnj skdjnfjsdnfolsdkj sdkljfoaisdfjio</p>
      </div>
      <div class="uk-card uk-card-default uk-width-1-4">
        dfsfse fesef esf se fseesfse ffs
      </div>
      <div class="uk-card uk-card-default uk-width-1-4">

      </div>
    </div>
  </div>
</body>

</html>
