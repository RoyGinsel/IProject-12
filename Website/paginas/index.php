<?php
session_start();
  include "functies.php";
  $crumbs = array();


 ?>
<html lang="nl" dir="ltr">

  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TEST</title>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  </head>
<body>

  <?php
  include "includes/header.php";
  ?>

<main class="page">

  <?php
  //call-out bericht
if(!isset($_COOKIE[$cookie_name])) {
    echo  '
    <div class="call-out uk-width-1-2 uk-text-center uk-position-center  uk-padding-large" uk-alert>
        <a class="sluiten uk-alert-close" uk-close ></a>
        <h2 class ="uk-text-small@s uk-text-large@m uk-margin-remove"> Welkom op de website!</h1>
        <p> Veel koop plezier </p> </div>';
}
    ?>
<!-- alert van aantal veilingen sinds laatste bezoek toegevoegd -->
    <div class="uk-alert-primary uk-margin-remove" uk-alert>
    <a class="uk-alert-close" uk-close></a>
<?php
if(isset($_COOKIE[$cookie_name])) {
    $changes = veranderingen($_COOKIE[$cookie_name]);
    $value = 0;
    foreach($changes as $row){
        $value = $row['aantal'];
    }
} else {
    $changes = veranderingen("2000/01/01");
    foreach($changes as $row){
        $value = $row['aantal'];
    }
}
    echo "<p class= 'uk-text-center'>Aantal veiling sinds laatste bezoek toegevoegd:$value</p>";
    ?>
</div>

<!-- voorfoto slideshow-->
<div class="uk-position-relative uk-visible-toggle uk-light " uk-slideshow="animation: fade min-height: 300; max-height: 600">

    <ul class="uk-slideshow-items uk-slid ">
        <li>
            <img src="../media/veiling-hamer.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom uk-height-max-medium">
                <h3 class="uk-margin-remove">Eenmaal Andermaal!</h3>
                <p class="uk-margin-remove">De duurzaam tweedhands item verkoop website van 2k18.</p>
            </div>
        </li>
        <li>
            <img src="../media/veiling-groep.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-left uk-text-center uk-transition-slide-left uk-width-medium">
                <h3 class="uk-margin-remove">Samen</h3>
                <p class="uk-margin-remove">nemen we stappen naar een duurzame samenleving</p>
            </div>
        </li>
        <li>
            <img src="../media/hamer-huis.jpg" alt="" uk-cover>
            <div class="uk-overlay uk-overlay-primary uk-position-right uk-text-center uk-transition-slide-right uk-width-medium ">
                <h3 class="uk-margin-remove">Fantastische items</h3>
                <p class="uk-margin-remove">De beste, goedkoopste items om op te bieden!</p>
            </div>
        </li>
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>


<!-- Lijsten "grid"-->
  <div class="uk-card uk-card-body tabel uk-margin-remove uk-child-width-1-2@m uk-child-width-1-1 uk-width-1-1 uk-flex-inline@m uk-flex-around@m " uk-grid>

<!-- tabel populaire-items -->
    <div class="uk-overflow-auto">
      <h2 class="uk-text-bold uk-text-center uk-text-large">Populaire items</h2>
    <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">

        <thead>
            <tr>
                <th class="uk-table-shrink">Product</th>
                <th class="uk-table-expand uk-visible@s">Omschrijving</th>
                <th class="uk-width-small uk-visible@s">Prijs</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
          <?php
          //gegevens halen uit de database en in tabel body zetten

          $lijst = "";
            foreach (populaireitems() as $waarde) {
           $lijst .= '
            <tr>
                <td><img class="uk-preserve-width uk-border-rounded " src=../media/Hamburgermenu.png width="80" alt="">
                <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">'.$waarde['titel'].'</h3></td>
                <td class="uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
                    <h4 class="uk-text-small">'.$waarde['beschrijving'].'</h4>
                </td>
                <td class="uk-visible@s">€ '.$waarde['bodBedrag'].'</td>
                <td><button class="uk-button uk-button-default" type="button" href="#">Ga naar bieding</button></td>

            </tr>';
          }
            echo $lijst;
            ?>


        </tbody>
    </table>
</div>

<!-- tabel uitgelichte-items -->

<div class="uk-overflow-auto">
  <h2 class="uk-text-bold uk-text-center uk-text-large">Uitgelichte items</h2>

        <div class="uk-height-max-medium">

<table id="test" class="uk-table uk-table-hover uk-table-middle uk-table-divider ">
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
      //gegevens halen uit de database en in tabel body zetten

      $lijst = "";
        foreach (uitgelichteitems() as $waarde) {
       $lijst .= '
        <tr>
            <td><img class="uk-preserve-width uk-border-rounded " src=../media/Hamburgermenu.png width="80" alt="">
            <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">'.$waarde['titel'].'</h3></td>
            <td class="uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
                <h4 class="uk-text-small">'.$waarde['beschrijving'].'</h4>
            </td>
            <td class="">€ '.$waarde['bodBedrag'].'</td>
            <td><button class="uk-button uk-button-default" type="button" href="#">Ga naar bieding</button></td>

        </tr>';
      }
        echo $lijst;
        ?>



    </tbody>
</table>
</div>
</div>
</main>
<?php
  include "includes/footer.php";
  ?>
</body>

</html>
