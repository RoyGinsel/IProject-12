<?php
    session_start();
    include "functies.php";
    $crumbs = array("Detailpagina");
    if(isset($_GET["data"])){
      $data = htmlspecialchars($_GET["data"]);
    } else {
      $data = 1;
    }
 ?>
 <!DOCTYPE html>
<html lang="nl" dir="ltr">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>EenmaalAndermaal</title>
    <script src="../css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
    <script src="../css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <!-- Header -->
  <?php
    include "includes/header.php";
  ?>
  <!-- Main inhoud Browser-->
    <main class="uk-visible@s uk-grid uk-margin-left uk-margin-top detailpaginaLayout uk-flex-center">
      <div class="uk-card uk-card-default uk-width-1-3">
        <div class="uk-card-media-top uk-margin-top" uk-slideshow>
          <ul class="uk-slideshow-items uk-slid uk-margin-right voorwerpFoto">
            <li>
                <img src="https://www.opumo.com/wordpress/wp-content/uploads/2018/04/OPUMO-1-7.jpg" alt="" uk-cover>
            </li>
            <li>
                <img src="https://ringbrothers.com/media/gallery/galleryimages//d/e/defector_2_.jpg" alt="" uk-cover>
            </li>
          </ul>
          <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
          <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
        </div>
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving:</h1>
          <ul class="voorwerpOmschrijving uk-margin-remove uk-padding-remove">
            <li class="uk-margin-top">Looptijd:</li>
            <li class="uk-margin-top">Gestart op:</li>
            <li class="uk-margin-top">Eindigd op:</li>
          </ul>
        </div>
      </div>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-left">
        <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Samenvatting:</h1>
        <table class="uk-table uk-table-divider uk-width-1-1 ">
          <tr>
            <td>Voorwerpnummer:</td>
            <td>1</td>
          </tr>
          <tr>
            <td>Locatie:</td>
            <td>Zeddam</td>
          </tr>
          <tr>
            <td>Betalingswijze:</td>
            <td>Paypal</td>
          </tr>
          <tr>
            <td>Betalingsinstructie:</td>
            <td>Maak over naar rekening: .......</td>
          </tr>
          <tr>
            <td>Startprijs:</td>
            <td>&euro; 80.000</td>
          </tr>
          <tr>
            <td>Verzendkosten:</td>
            <td>&euro; 2</td>
          </tr>
          <tr>
            <td>Verkoper:</td>
            <td>Dex</td>
          </tr>
        </table>
      </div>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-3 uk-margin-top">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
          <form action="" method="post" class="uk-panel uk-panel-box uk-form">
            <div class="uk-form-row">
              <input class="uk-width-1-3 uk-form-large" name="invoerBod" type="number"  placeholder="Bod" required>
              <input class="uk-button uk-button-primary uk-width-1-2 uk-padding-remove knopje" type="Submit" name="Bod" value="Bieden">
            </div>
          </form>
        </div>
        <div class="uk-body">
            <table class="uk-table uk-table-middle uk-table-divider ">
              <tr>
                <th>Gebruiker:</th>
                <th>Bod:</th>
                <th>Datum en Tijd:</th>
              </tr>
            </table>
        </div>
      </div>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-top uk-margin-left">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Reacties op verkoper:</h1>
        </div>
        <div class="uk-body">
            <table class="uk-table uk-table-middle uk-table-divider ">
              <tr>
                <th>Commentaar:</th>
                <th>Van:</th>
                <th>Datum en Tijd:</th>
                <th>Voorwerp:</th>
              </tr>
            </table>
        </div>
      </div>
    </main>

    <!-- Main inhoud Mobile-->
      <main class="uk-hidden@s uk-grid uk-margin-left uk-margin-right uk-margin-top detailpaginaLayout">
        <div class="uk-card uk-card-default uk-width-1-1">
          <div class="uk-card-media-top uk-margin-top" uk-slideshow>
            <ul class="uk-slideshow-items uk-slid uk-margin-right voorwerpFotoMobile">
              <li>
                  <img src="https://www.opumo.com/wordpress/wp-content/uploads/2018/04/OPUMO-1-7.jpg" alt="" uk-cover>
              </li>
              <li>
                  <img src="https://ringbrothers.com/media/gallery/galleryimages//d/e/defector_2_.jpg" alt="" uk-cover>
              </li>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
          </div>
          <h1 class="uk-card-title uk-margin-remove uk-width-1-3">Omschrijving:</h1>
          <div class="uk-width-1-1 uk-card-title SamenvattingMobile">
              <div>
                <h1>Looptijd:</h1>
                <p></p>
              </div>
              <div>
                <h1>Gestart op:</h1>
                <p></p>
              </div>
              <div>
                <h1>Eindigd op:</h1>
                <p></p>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <h1 class="uk-card-title uk-margin-remove uk-width-1-3">Samenvatting:</h1>
          <div class="uk-width-1-1 uk-card-title SamenvattingMobile">
            <div>
              <h1>Voorwerpnummer:</h1>
              <p>1</p>
            </div>
            <div>
              <h1>Locatie:</h1>
              <p>Zeddam</p>
            </div>
            <div>
              <h1>Betalingswijze:</h1>
              <p>Paypal</p>
            </div>
            <div>
              <h1>Betalingsinstructie:</h1>
              <p>Maak over naar rekening:</p>
            </div>
            <div>
              <h1>Startprijs:</h1>
              <p>&euro; 80.000</p>
            </div>
            <div>
              <h1>Verzendkosten:</h1>
              <p>&euro; 2</p>
            </div>
            <div>
              <h1>Verkoper:</h1>
              <p>Dex</p>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
            <form action="" method="post" class="uk-panel uk-panel-box uk-form">
              <div class="uk-form-row uk-margin uk-padding-remove">
                <input class="uk-width-1-1 uk-input uk-form-width-medium uk-form-default" name="invoerBod" type="number"  placeholder="Bod" required>
                <input class="uk-button uk-button-primary uk-width-1-1 uk-padding-remove" type="Submit" name="Bod" value="Bieden">
              </div>
            </form>
          </div>
          <div class="uk-body">
              <div class="uk-width-1-1 SamenvattingMobile">
                <div class="uk-margin-top">
                  <h1>Gebruiker:</h1>
                  <p>Dex</p>
                </div>
                <div>
                  <h1>Bod:</h1>
                  <p>&euro; 20.000</p>
                </div>
                <div>
                  <h1>Datum:</h1>
                  <p></p>
                </div>
              </div>
          </div>
        </div>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Reacties op verkoper:</h1>
          </div>
          <div class="uk-body">
              <div class="uk-width-1-1 SamenvattingMobile">
                <div class="uk-margin-top">
                  <h1>Commentaar:</h1>
                  <p>Geweldige verkoper!</p>
                </div>
                <div>
                  <h1>Van:</h1>
                  <p>Simon</p>
                </div>
                <div>
                  <h1>Datum:</h1>
                  <p></p>
                </div>
                <div>
                  <h1>Voorwerp:</h1>
                  <p>Fiets</p>
                </div>
              </div>
          </div>
        </div>
      </main>
    <!-- Footer -->
  <?php
    include "includes/footer.php";
  ?>
</body>
</html>