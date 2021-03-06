<?php
    session_start();
    include "functies.php";
    $crumbs = array("Producten", "Detailpagina");
    if(isset($_GET["data"])){
      $data = htmlspecialchars($_GET["data"]);
    } else {
      $data = 1;
    }

    $itemID = $_GET['item'];
    $info = getProductinfo($itemID);
    $seller = getseller($itemID);
    $review = getReview($seller[0]['verkoper']);
// Functie die hoogste bieding krijgt
    $highestBid;
    if (isset(getHighestBid($itemID)[0]['startPrijs'])){
      $highestBid = $info[0]['startPrijs'];
    } else{
      $highestBid = getHighestBid($itemID);
      $highestBid = $highestBid[0]['HoogsteBod'];
    }
// maakt een leesbare error message
    $error;
    if(isset($_POST['invoerBod']) && isset($_SESSION['username'])){
      $error = addNewBid($_POST['invoerBod'],$itemID,$_SESSION['username']);
      $error = substr($error,71);
    }
    $fotos = preparedQuery("SELECT * FROM tblBestand WHERE voorwerpNummer = :nummer",["nummer" => $_GET['item']]);

 ?>

 <!DOCTYPE html>
<html lang="nl" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EenmaalAndermaal</title>
    <script src="../css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
    <script src="../css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<!-- Script om countdown te krijgen bij producten -->
<script>
   // Vul de datum in vanaf hij moet aftellen, wij hebben uit de database de einde dag en tijd gehaald.
   var countDownDate = new Date(<?php echo "'". $info[0]['looptijdEindeDag'] ." ". $info[0]['looptijdEindeTijdstip']. "'"?>);
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
   // Output het resultaat in de ID
   document.getElementById("cntdwn").innerHTML = dagen + "d " + uren + "u "
   + minuten + "m " + seconden + "s ";
   document.getElementById("cntdwnMobile").innerHTML = dagen + "d " + uren + "u "
   + minuten + "m " + seconden + "s ";
   // Wanneer de countdown bij '0' is, plaats wat tekst
   if (distance < 0) {
       clearInterval(x);
       document.getElementById("cntdwn").innerHTML = "Verlopen";
       document.getElementById("cntdwnMobile").innerHTML = "Verlopen";
   }
}, 1000);
</script>

<body>
  <!-- Header -->
  <?php
    include "includes/header.php";
  ?>
  <!-- Main inhoud Browser-->
    <main class="uk-visible@m uk-grid uk-margin-left uk-margin-top detailpaginaLayout uk-flex-center">
      <div class="uk-card uk-card-default uk-width-1-3">
        <div class="uk-card-media-top uk-margin-top" uk-slideshow>
          <ul class="uk-slideshow-items uk-slid uk-margin-right uk-border-rounded voorwerpFoto">
              <?php
              foreach ($fotos as $value) {
                $BestandNaam = $value['fileNaam'] ;
                if(strpos($BestandNaam,"N") == 0 && strpos($BestandNaam,"D") == 1 && strpos($BestandNaam,"B") == 2 && strpos($BestandNaam,"_") == 3){
                  $src = "../../images/".$value['fileNaam'];
                } else {
                  $src = "../../pics/".$value['fileNaam'];
                }
                echo "<li> <img src='$src' uk-cover> </li>";
              } ?>
          </ul>
        </div>
          <!-- omschrijving lol -->
          <?php
          $begintijd;
          $eindetijd;
           if($info[0]['looptijdBeginDag'] == '2000-01-01'){
             $begintijd = "Geblokkeerd";
             $eindetijd = "Geblokkeerd";
           }else {
             $begintijd= $info[0]['looptijdBeginDag'];
             $eindetijd= $info[0]['looptijdEindeDag'];
           }
        $omschrijving = '
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving</h1>
          <ul class="voorwerpOmschrijving uk-margin-remove uk-padding-remove">
            <li class="uk-margin-top">Titel: '.$info[0]['titel']. '</li>
            <li class="uk-margin-top uk-margin-right">Omschrijving: '.$info[0]['beschrijving']. '</li>
            <li class="uk-margin-top">Looptijd: <span id="cntdwn"></span> </li>
            <li class="uk-margin-top">Gestart op: '.$begintijd. '</li>
            <li class="uk-margin-top">Eindigd op: '.$eindetijd. '</li>
            <li class="uk-margin-top uk-margin-bottom"><strong>Hoogste bod: &euro; '.$highestBid. '</strong></li>
        </div>
      </div>
      ';
      echo $omschrijving;
       //samenvatting

       $samenvatting = '
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-left">
        <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Samenvatting:</h1>
        <table class="uk-table uk-table-divider uk-width-1-1 ">
          <tr>
            <td>Voorwerpnummer:</td>
            <td>'.$info[0]['voorwerpNummer'].'</td>
          </tr>
          <tr>
            <td>Locatie:</td>
            <td>'.$info[0]['plaatsnaam'].', '.$info[0]['land'].'</td>
          </tr>
          <tr>
            <td>Betalingswijze:</td>
            <td>'.$info[0]['betaalWijze'].'</td>
          </tr>
          <tr>
            <td>Betalingsinstructie:</td>
            <td>'.$info[0]['betalingsInstructie'].'</td>
          </tr>
          <tr>
            <td>Startprijs:</td>
            <td>&euro; '.$info[0]['startPrijs'].'</td>
          </tr>
          <tr>
            <td>Verzendkosten:</td>
            <td>&euro; '.$info[0]['verzendkosten'].'</td>
          </tr>
          </table>
          <table class="uk-table uk-table-divider uk-width-1-1 ">
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

     echo $samenvatting;
      ?>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-3 uk-margin-top">
      <?php
            if(!isset($_SESSION['username'])){
              echo "<div class='uk-alert-danger' uk-alert>
                  <a class='uk-alert-close' uk-close></a>
                  <p> U moet ingelogd zijn om te kunnen bieden </p>
                  </div>";
            } elseif(isset($error)){
              echo "<div class='uk-alert-danger' uk-alert>
                    <a class='uk-alert-close' uk-close></a>
                    <p> $error </p>
                    </div>";
            }
          ?>
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
          <form action="#" method="post" class="uk-panel uk-panel-box uk-form">
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
              <?php
                foreach(getAllBids($itemID) as $row){
                  echo '
                      <tr>
                        <td>'.$row['gebruiker'].'</td>
                        <td> &euro;'.$row['bodBedrag'].'</td>
                        <td>'.$row['bodDag'].' - '. substr($row['bodTijdstip'],0,8).'</td>
                      </tr>'; };
              ?>
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
            <?php
              foreach($review as $item => $key){
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
      <main class="uk-hidden@m uk-grid uk-margin-left uk-margin-right uk-margin-top detailpaginaLayout">
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
        $mobileomschrijving = '
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving</h1>
          <ul class="voorwerpOmschrijving uk-padding-remove">
            <li class="uk-margin-top">Titel: '.$info[0]['titel']. '</li>
            <li class="uk-margin-top uk-margin-right">Omschrijving: '.$info[0]['beschrijving']. '</li>
            <li class="uk-margin-top">Looptijd: <span id="cntdwnMobile"></span> </li>
            <li class="uk-margin-top">Gestart op: '.$begintijd.'</li>
            <li class="uk-margin-top">Eindigd op: '.$eindetijd. '</li>
            <li class="uk-margin-top"><strong>Hoogste bod: &euro; '.$highestBid. '</strong></li>
          </ul>
        </div>
      </div>
      </div>
      ';
      echo $mobileomschrijving;


      $mobilesamenvatting = '
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <h1 class="uk-card-title uk-margin-remove uk-width-1-3">Samenvatting:</h1>
          <div class="uk-width-1-1 uk-card-title SamenvattingMobile">
            <div>
              <h1>Voorwerpnummer:</h1>
              <p>'.$info[0]['voorwerpNummer'].'</p>
            </div>
            <div>
              <h1>Locatie:</h1>
              <p>'.$info[0]['plaatsnaam'].'</p>
            </div>
            <div>
              <h1>Betalingswijze:</h1>
              <p>'.$info[0]['betaalWijze'].'</p>
            </div>
            <div>
              <h1>Betalingsinstructie:</h1>
              <p>'.$info[0]['betalingsInstructie'].':</p>
            </div>
            <div>
              <h1>Startprijs:</h1>
              <p>&euro; '.$info[0]['startPrijs'].'</p>
            </div>
            <div>
              <h1>Verzendkosten:</h1>
              <p>&euro; '.$info[0]['verzendkosten'].'</p>
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

        echo $mobilesamenvatting;

        ?>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <?php
            if(!isset($_SESSION['username'])){
              echo "<div class='uk-alert-danger' uk-alert>
                  <a class='uk-alert-close' uk-close></a>
                  <p> U moet ingelogd zijn om te kunnen bieden </p>
                  </div>";
            } elseif(isset($error)){
              echo "<div class='uk-alert-danger' uk-alert>
                    <a class='uk-alert-close' uk-close></a>
                    <p> $error </p>
                    </div>";
            }
          ?>
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
            <form action="#" method="post" class="uk-panel uk-panel-box uk-form">
              <div class="uk-form-row uk-margin uk-padding-remove">
                <input class="uk-width-1-1 uk-input uk-form-width-medium uk-form-default" name="invoerBod" type="number"  placeholder="Bod" required>
                <input class="uk-button uk-button-primary uk-width-1-1 uk-padding-remove uk-margin-top" type="Submit" name="Bod" value="Bieden">
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
              <?php
                foreach(getAllBids($itemID) as $row){
                  echo '
                      <tr>
                        <td>'.$row['gebruiker'].'</td>
                        <td> &euro;'.$row['bodBedrag'].'</td>
                        <td>'.$row['bodDag'].' '. substr($row['bodTijdstip'],0,8).'</td>
                      </tr>'; };
              ?>
            </table>
          </div>
        </div>



        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
          <div class="uk-card-header">
            <h1 class="uk-card-title uk-padding-remove uk-text-center">Reacties op verkoper:</h1>
          </div>
          <div class="uk-body uk-overflow-auto  uk-height-medium">
              <div class="uk-width-1-1 SamenvattingMobile">
                <div class="uk-margin-top ">
                <?php
                      foreach($review as $item => $key){

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
