<?php
    session_start();
    include "functies.php";
    $crumbs = array("Detailpagina");
    if(isset($_GET["data"])){
      $data = htmlspecialchars($_GET["data"]);
    } else {
      $data = 1;
    }
    $productInfo = getProductinfo($_GET['item']);
    $seller = getseller($_GET['item']);
    $feedback = getReview($seller[0]['verkoper']);
 ?>
 <!-- Script om countdown te krijgen bij producten -->
 <script>
    // Vul de datum in vanaf hij moet aftellen, wij hebben uit de database de einde dag en tijd gehaald.
    var countDownDate = new Date(<?php echo "'". $productInfo[0]['looptijdEindeDag'] ." ". $productInfo[0]['looptijdEindeTijdstip']. "'"?>);
  // var countDownDate = new Date('2018-05-29T10:30:00')
    // Zorgt voor de countdown met 1 seconden per refresh
    var x = setInterval(function() {
    // Door deze functie krijg je de huidige datum en tijd. (Je eigen PC tijd)
    var now = new Date();
    // Berekent de tijd vanaf je huidige datum en de opgegeven datum
    var distance = countDownDate - now;
    // Functies die zorgen voor het calculeren van de tijden
    var dagen = Math.floor(distance / (1000 * 60 * 60 * 24));
    var uren = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minuten = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconden = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result in an element with id
    document.getElementById("cntdwn").innerHTML = dagen + "d " + uren + "u "
    + minuten + "m " + seconden + "s ";
    // If the count down is over, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("cntdwn").innerHTML = "Verlopen";
    }
}, 1000);
</script>

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
          <ul class="uk-slideshow-items uk-slid uk-margin-right uk-border-rounded voorwerpFoto">
            <li>
                <img src="https://www.opumo.com/wordpress/wp-content/uploads/2018/04/OPUMO-1-7.jpg" alt="" uk-cover>
            </li>
            <li>
                <img src="https://ringbrothers.com/media/gallery/galleryimages//d/e/defector_2_.jpg" alt="" uk-cover>
            </li>
          </ul>
        </div>
<<<<<<< HEAD
          <!-- omschrijving lol -->
=======


          <!-- omschrijving $productInfo bevat de array met gegevens -->
>>>>>>> 802c135e2a0d66daa42e600b5f5d5f7cc37cb325
          <?php
        $description = '
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving</h1>
          <ul class="voorwerpOmschrijving uk-margin-remove uk-padding-remove">
            <li class="uk-margin-top">Titel: '.$productInfo[0]['titel']. '</li>
            <li class="uk-margin-top uk-margin-right">Omschrijving: '.$productInfo[0]['beschrijving']. '</li>
            <li class="uk-margin-top">Looptijd: <span id="cntdwn"></span> </li>
            <li class="uk-margin-top">Gestart op: '.$productInfo[0]['looptijdBeginDag']. '</li>
            <li class="uk-margin-top">Eindigd op: '.$productInfo[0]['looptijdEindeDag']. '</li>
        </div>
      </div>
      ';
      echo $description;
      ?>
       <!-- samenvatting -->
       <?php

       $resume = '
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-left">
        <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Samenvatting:</h1>
        <table method="post" class="uk-table uk-table-divider uk-width-1-1 ">
          <tr>
            <td>Voorwerpnummer:</td>
            <td>'.$productInfo[0]['voorwerpNummer'].'</td>
          </tr>
          <tr>
            <td>Locatie:</td>
            <td>'.$productInfo[0]['plaatsnaam'].', '.$productInfo[0]['land'].'</td>
          </tr>
          <tr>
            <td>Betalingswijze:</td>
            <td>'.$productInfo[0]['betaalWijze'].'</td>
          </tr>
          <tr>
            <td>Betalingsinstructie:</td>
            <td>'.$productInfo[0]['betalingsInstructie'].'</td>
          </tr>
          <tr>
            <td>Startprijs:</td>
            <td>&euro; '.$productInfo[0]['startPrijs'].'</td>
          </tr>
          <tr>
            <td>Verzendkosten:</td>
            <td>&euro; '.$productInfo[0]['verzendkosten'].'</td>
          </tr>
          </table>
          <table method="post" class="uk-table uk-table-divider uk-width-1-1 ">
          <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Info over verkoper:</h1>
          <tr>
            <td>Naam:</td>
            <td>'.$seller[0]['verkoper'].'</td>
          </tr>
          <tr>
            <td>Succesvolle verkopen:</td>
            <td>'.$seller[0]['succesvolleVerkopen'].'</td>
          </tr>
          <tr>
            <td>Lid sinds:</td>
            <td>'.$seller[0]['lidSinds'].'</td>
          </tr>
        </table>
      </div>
     ';

     echo $resume;
      ?>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-3 uk-margin-top">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
          <form action="" method="post" class="uk-panel uk-panel-box uk-form">
            <div class="uk-form-row">
              <input class="uk-width-1-3 uk-form-large" name="invoerBod" type="number"  placeholder="Bod" required>
              <input class="uk-button uk-button-primary uk-width-1-2  uk-padding-remove" type="Submit" name="Bod" value="Bieden">
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
        <div class="uk-body uk-overflow-auto uk-height-medium">
            <table class="uk-table uk-table-middle uk-table-divider ">
              <tr>
                <th>Datum en Tijd:</th>
                <th>Commentaar:</th>
                <th>Voorwerp:</th>
                <th>Feedback:</th>
              </tr>

              <!-- weergeeft alle feedback weer door ze met een foreach loop uit de database te halen -->
            <?php
              foreach($feedback as $item => $key){
                echo '
                      <tr>
                        <td>'.$key['dag'].' / '.substr($key['tijd'],0,8).'</td>
                        <td>'.$key['commentaar'].'</td>
                        <td>'.$key['titel'].'</td>
                        <td>'.$key['feedbackSoort'].'</td> 
                      </tr>'; };
                ?>
            </table>
        </div>
      </div>
    </main>


    <!-- Main inhoud Mobile-->
      <main class="uk-hidden@s uk-grid uk-margin-left uk-margin-right uk-margin-top detailpaginaLayout">
        <div class="uk-card uk-card-default uk-width-1-1">
          <div class="uk-card-media-top uk-margin-top" uk-slideshow>
            <ul class="uk-slideshow-items uk-slid uk-margin-right uk-border-rounded voorwerpFotoMobile">
              <li>
                  <img src="https://www.opumo.com/wordpress/wp-content/uploads/2018/04/OPUMO-1-7.jpg" alt="" uk-cover>
              </li>
              <li>
                  <img src="https://ringbrothers.com/media/gallery/galleryimages//d/e/defector_2_.jpg" alt="" uk-cover>
              </li>
            </ul>

            <?php
        $mobiledescription = '
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving</h1>
          <ul class="voorwerpOmschrijving uk-padding-remove">
            <li class="uk-margin-top">Titel: '.$productInfo[0]['titel']. '</li>
            <li class="uk-margin-top">Omschrijving: '.$productInfo[0]['beschrijving']. '</li>
            <li class="uk-margin-top">Looptijd: '.$productInfo[0]['looptijd']. ' dagen</li>
            <li class="uk-margin-top">Gestart op: '.$productInfo[0]['looptijdBeginDag']. '</li>
            <li class="uk-margin-top">Eindigd op: '.$productInfo[0]['looptijdEindeDag']. '</li>
          </ul>
        </div>
      </div>
      </div>
      ';
      echo $mobiledescription;
      ?>

<!-- mobiel samenvatting weergave  -->
        <?php

    
      $mobileresume = '
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <h1 class="uk-card-title uk-margin-remove uk-width-1-3">Samenvatting:</h1>
          <div class="uk-width-1-1 uk-card-title SamenvattingMobile">
            <div>
              <h1>Voorwerpnummer:</h1>
              <p>'.$productInfo[0]['voorwerpNummer'].'</p>
            </div>
            <div>
              <h1>Locatie:</h1>
              <p>'.$productInfo[0]['plaatsnaam'].'</p>
            </div>
            <div>
              <h1>Betalingswijze:</h1>
              <p>'.$productInfo[0]['betaalWijze'].'</p>
            </div>
            <div>
              <h1>Betalingsinstructie:</h1>
              <p>'.$productInfo[0]['betalingsInstructie'].':</p>
            </div>
            <div>
              <h1>Startprijs:</h1>
              <p>&euro; '.$productInfo[0]['startPrijs'].'</p>
            </div>
            <div>
              <h1>Verzendkosten:</h1>
              <p>&euro; '.$productInfo[0]['verzendkosten'].'</p>
            </div>
            <div>
              <h1 class="uk-card-title uk-text-center uk-margin-bottom uk-width-1-1">Informatie over verkoper:</h1>
            </div>
            <div>
              <h1>Verkoper:</h1>
              <p>'.$seller[0]['verkoper'].'</p>
            </div>
            <div>
              <h1>succesvolle verkopen:</h1>
              <p>'.$seller[0]['succesvolleVerkopen'].'</p>
            </div>
            <div>
              <h1>lid sinds:</h1>
              <p>'.$seller[0]['lidSinds'].'</p>
            </div>
          </div>
        </div>

        ';

        echo $mobileresume;
        ?>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
            <form action="" method="post" class="uk-panel uk-panel-box uk-form">
              <div class="uk-form-row uk-margin uk-padding-remove">
                <input class="uk-width-1-1 uk-input uk-form-width-medium uk-form-default" name="invoerBod" type="number"  placeholder="Bod" required>
                <input class="uk-button uk-button-primary uk-width-1-1 uk-padding-remove uk-margin-top" type="Submit" name="Bod" value="Bieden">
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


  <!-- Reacties op verkoper mobile -->
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Reacties op verkoper:</h1>
          </div>
          <div class="uk-body uk-overflow-auto  uk-height-medium">
              <div class="uk-width-1-1 SamenvattingMobile">
                <div class="uk-margin-top ">

                <!-- haalt de feedback met een foreach uit de database.-->
                <?php
                      foreach($feedback as $item => $key){
                        
                        echo '  
                      <div>
                        <h1>Datum en tijd:</h1>
                        <p>'.$key['dag'].' / '.substr($key['tijd'],0,8).'</p>
                      </div>
                      <div>
                        <h1>Commentaar:</h1>
                        <p>'.$key['commentaar'].'</p>
                      </div>
                      <div>
                        <h1>Voorwerp:</h1>
                        <p>'.$key['titel'].'</p>
                      </div>
                      <div>
                        <h1>Feedback</h1>
                        <p>'.$key['feedbackSoort'].'</p>
                      </div>';
                      echo "<hr>";
                                 
                       };
                        ?>
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
