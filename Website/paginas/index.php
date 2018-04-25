<?php
session_start();
  //include('..\SQLSrvConnect.php');
  $cookie_name = "callout";
  $cookie_value = "cookieVoorCallout";

if(!isset($_COOKIE[$cookie_name])){
    setcookie($cookie_name ,$cookie_value,time() + (86400 * 30),"/",null,null,null);
}
 ?>
<html lang="nl" dir="ltr">

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

<main class="page">

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
    <div class="call-out" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <h1> Welkom op de website!</h1>
        <p> Veel koop plezier </p> </div>';
}
    ?>
    <div class="uk-alert-primary uk-margin-remove" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p class= "uk-text-center">Aantal veiling sinds laatste bezoek toegevoegd: ..</p>
</div>
<!-- voorfoto -->
<div class="uk-position-relative uk-visible-toggle uk-light" uk-slideshow="animation: fade">

    <ul class="uk-slideshow-items uk-slid">
        <li>
            <img src="../media/veiling-hamer.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom uk-height-max-medium">
                <h3 class="uk-margin-remove">Bottom</h3>
                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </li>
        <li>
            <img src="../media/veiling-groep.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-left uk-text-center uk-transition-slide-left uk-width-medium">
                <h3 class="uk-margin-remove">Bottom</h3>
                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </li>
        <li>
            <img src="../media/hamer-huis.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-right uk-text-center uk-transition-slide-right uk-width-medium ">
                <h3 class="uk-margin-remove">Left</h3>
                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </li>
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>


<!-- Lijsten -->
  <div class="uk-card uk-card-default uk-card-body uk-child-width-1-2@m uk-child-width-1-1 uk-width-1-1 uk-flex-inline@m uk-flex-around@m" uk-grid>

<!-- tabel populaire-items -->
    <div class="uk-overflow-auto">
      <h2 class="uk-text-bold uk-text-center uk-text-large">Populaire items</h2>
    <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
        <thead>
            <tr>
                <th class="uk-table-shrink">Product</th>
                <th class="uk-table-expand uk-visible@s">Omschrijving</th>
                <th class="uk-width-small">Prijs</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
          <?php
  //         $sql = "SELECT title, image,omschrijving,prijs,link from tabelnaam ";
  //         $query = $dbh->prepare($sql);
  //         $query->execute($sql);
  // //fetch de uitkomst en stop het in een array resultaat
  //         $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
  //           foreach ($resultaat as $waarde) { }
  //         $lijst .= '
  //           <tr>
  //               <td><img class="uk-preserve-width uk-border-rounded " src="'.$waarde['image'].'" width="80" alt="">
  //               <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">'.$waarde['title'].'</h3></td>
  //               <td class="uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
  //                   <h4 class="uk-text-small">'.$waarde['omschrijving'].'</h4>
  //               </td>
  //               <td class="">'.$waarde['prijs'].'</td>
  //               <td><button class="uk-button uk-button-default" type="button" href="'.$waarde['link'].'">Ga naar bieding</button></td>
  //
  //           </tr>'
            ?>
            <tr>
                <td><img class="uk-preserve-width uk-border-rounded " src="../media/Hamburgermenu.png" width="80" alt="">
                <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">Mazda MX5</h3></td>
                <td class=" uk-text-truncate uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
                    <h4 class="uk-text-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</h4>
                </td>
                <td class="">$120948</td>
                <td><button class="uk-button uk-button-default" type="button" href="#">Button</button></td>

            </tr>
        </tbody>
    </table>
</div>

<!-- tabel uitgelichte-items -->
<div class="uk-overflow-auto">
  <h2 class="uk-text-bold uk-text-center uk-text-large">Populaire items</h2>
<table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
    <thead>
        <tr>
            <th class="uk-table-shrink">Product</th>
            <th class="uk-table-expand uk-visible@s">Omschrijving</th>
            <th class="uk-width-small">Prijs</th>
            <th class="uk-table-shrink uk-text-nowrap"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><img class="uk-preserve-width uk-border-rounded " src="../media/mazda.png" width="80" alt="">
            <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">Mazda MX5</h3></td>
            <td class=" uk-text-truncate uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
                <h4 class="uk-text-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</h4>
            </td>
            <td class="">$120948</td>
            <td><button class="uk-button uk-button-default" type="button" href="#">Button</button></td>

        </tr>
    </tbody>
</table>
</div>
</div>
</main>
</body>

</html>
