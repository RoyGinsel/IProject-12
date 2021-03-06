<?php
session_start();
$crumbs = array('Mijn-Veilingen');
include "functies.php";

if(!getPossibleBuyer($_SESSION['username'])){
    header('Location: index.php');
  };

if(isset($_SESSION['username'])){
    checkIfBlocked($_SESSION['username']);
 }

//Als er een post is gestuurd om een item aan te bieden
if (isset($_POST['Titel']) ){
    //Tellen van aantal geuploadde fotos
  $_aantal_fotos = count($_FILES['fotos']['name']);
  var_dump($_FILES['fotos']['name']);
  var_dump($_aantal_fotos);
  $insertOK = 0;
  //error messages
  if($_FILES['fotos']['name'][0] =="" ){
    $insertOK = 1;
    echo "<script>
    alert('Upload tenminste één bestand');
    </script>";
  } if($_aantal_fotos > 5){
    $insertOK = 1;
    echo "<script>
    alert('Je kunt maximaal 4 fotos uploaden');
    </script>";
    }
      //Insert van gegevens in db
  if($_FILES['fotos']['name'][0] !="" && $_aantal_fotos < 6 && $insertOK == 0) {
    $nummer = newVoorwerpNummer();
    $nummer = $nummer[0]['voorwerpnummer'];
    preparedInsertQuery("INSERT INTO tblVoorwerp values(".$nummer.",:titel,:beschrijving,:startPrijs,:betaalWijze,:betalingsInstructie,
        :plaatsnaam,:land,:looptijd,convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP),:verzendkosten,:verzendinstructie,:verkoper)",
        ["titel" => $_POST['Titel'], "beschrijving" => $_POST['Beschrijving'], "startPrijs" => $_POST['Startprijs'], "betaalWijze" => $_POST['Bank'],
        "betalingsInstructie" => $_POST['Betaalinstructie'], "plaatsnaam" => $_POST['Plaatsnaam'], "land" => $_POST['Land'], "looptijd" => $_POST['Looptijd'],
        "verzendkosten" => $_POST['Verzendkosten'], "verzendinstructie" => $_POST['Verzendinstructie'], "verkoper" => $_SESSION['username'] ]);
  foreach($_POST['Rubriekaanbieden'] as $value){
  preparedInsertQuery("INSERT INTO tblVoorwerpRubriek Values(".$nummer.",:rubriek)", ["rubriek" => $value]);
  }
    //fotos uploaden
    $doel_map = "../../images/NDB_item".$nummer;
      for ($i=0; $i <= count($_FILES['fotos']['name']); $i++) {
        if(basename($_FILES["fotos"]["name"][$i]) != ""){
          preparedInsertQuery("INSERT INTO tblBestand values(:fotonaam, :nummer)",
          ['fotonaam' => "NDB_item".$nummer.basename($_FILES["fotos"]["name"][$i]) , 'nummer' => $nummer]);
          // Geef de bestandnaam op van het bestand op een bepaalde locatie
          $doel_bestand = $doel_map . basename($_FILES["fotos"]["name"][$i]);
          $uploadOk = 1;
          //kijkt welke extensie de afbeelding heeft
          $afbeelding_type = strtolower(pathinfo($doel_bestand, PATHINFO_EXTENSION));
          // Bepaalde bestand extensies toestaan
          if ($afbeelding_type != "jpg" && $afbeelding_type != "png" && $afbeelding_type != "jpeg"
              && $afbeelding_type != "gif") {
              $melding = "Sorry, alleen JPG, JPEG, PNG & GIF files zijn toegestaan.";
              $uploadOk = 0;
          }
          // kijken of $uploadOk 0 is door een error hier boven
          if ($uploadOk === 1) {
              if (move_uploaded_file($_FILES["fotos"]["tmp_name"][$i], $doel_bestand)) {
                  $melding = "Het bestand " . basename($_FILES["fotos"]["name"][$i]) . " is geupload.";
              } else {
                  $melding = "Sorry, er was een error bij het uploaden van het bestand.";
              }
          }
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EenmaalAndermaal</title>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
  <script type="text/javascript" src="../css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php
    include "includes/header.php";
    $myAuctions = getAuctions($_SESSION['username']);
  ?>
    <main class="page uk-margin-left uk-margin-right">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk uk-text-center uk-margin-bottom">Mijn veilingen:</h1>
        </div>
        <div class="uk-body uk-height-large uk-overflow-auto">
            <table class="uk-table uk-table-middle uk-table-responsive  uk-table-divider uk-table-hover">
            <thead>
                <tr>
                    <th>Voorwerp</th>
                    <th>Datum plaatsing</th>
                    <th>Huidige bod:</th>
                    <th>Resterende duur veiling:</th>
                    <th>Ga naar veiling </th>
                </tr>
              </thead>
              <tbody>
              <?php
            $salesItems = "";
            foreach($myAuctions as $item => $key){
                // bepaalt de tijd en datum van het moment
              $DateOfToday = new DateTime(date("d-m-Y H:i:s"));

              // zet de eind datum  en tijd van het voorwerp in end date
              $endDate = new DateTime($key['looptijdEindeDag'].$key['looptijdEindeTijdstip']);

              // rekent het verschill uit tussen de dag en tijd van vandaag en de einddag en tijd
              $difference = $DateOfToday->diff($endDate);
                $timeRemaining;
                if($key['veilingGesloten'] == 0){
                    $timeRemaining = format_interval($difference);

                } else {
                    $timeRemaining = 'Veiling gesloten';
                }
               if(empty($key['bodBedrag'])){
                    $prijs =  $key['startPrijs'];
                    } else {
                        $prijs = $key['bodBedrag'];
                     };
                $geblokkeerd;
                 if($key['looptijdBeginDag'] == '2000-01-01'){
                   $geblokkeerd = "Geblokkeerd";
                 }else {
                   $geblokkeerd= $key['looptijdBeginDag'];
                 }
                    $salesItems .= '
                    <tr>
                    <td>'.$key['titel'].'</td>
                    <td>'.$geblokkeerd.' </td>
                    <td>€ '.$prijs.'</td>
                    <td>'. $timeRemaining.' </td>
                    <td>
                    <a class="uk-button uk-button-default uk-padding-small" type="button" href="detailpagina.php?item='.$key['voorwerpNummer'].'">Ga naar veiling</a>
                    </td>
                    </tr>';
                  // print de items weer.
                };
                echo $salesItems;
               ?>
              </tbody>
            </table>
        </div>
    </div>
    <div class='uk-margin-top'>
        <p>
            <a class="uk-button uk-margin-right uk-padding-small uk-button-primary" href="index.php">Home</a>
            <a class="uk-button uk-margin-right uk-padding-small uk-button-primary" href="Producten.php">Producten</a>
            <a id="toggle-form" href="#toggle-animation" class=" uk-padding-small uk-button uk-button-primary uk-button-default" type="button"
             uk-toggle="target: #toggle-animation; animation: uk-animation-fade"> Item aanbieden </a>
        </p>
    </div>

<div id="toggle-animation" class=" uk-card uk-card-default uk-card-body uk-margin-small" hidden>

<form action="Mijn-Veilingen.php" method="post" enctype="multipart/form-data">
  <div class="uk-form uk-width-1-1 uk-flex uk-flex-inline@m uk-flex-center uk-margin-medium-top">
  <div class="uk-flex uk-flex-column">
    <!-- Plek waar de geladen rubrieken komen -->
    <select id="rubrieken" class="uk-width-1-1 uk-form-select" name="Rubriekaanbieden[]" multiple required>
    </select>
    <div class="uk-flex uk-flex-center">
    <div class="uk-flex uk-flex-around uk-flex-column uk-margin-small-left uk-text-nowrap">
      <span>Titel:</span>
      <span>Plaatsnaam:</span>
      <span>Land:</span>
      <span>Startprijs:</span>
      <span>Verzendkosten:</span>
      <span>Looptijd:</span>
      <span>Bank:</span>
      <span>Banknummer:</span>
    </div>

    <?php
    //Form ids in een array gezet zodat die makkelijker aangepast kunnen worden
    $form_ids = ["Titel" => "titel",
    "Plaatsnaam" => "plaatsnaam",
    "Land" => "land",
    "Startprijs" => "startprijs",
    "Verzendkosten" => "verzendkosten",
    "Looptijd" =>"looptijd",
    "Bank" => "bank",
    "Banknummer" => "banknummer",
    "Verzendinstructie" => 'Verzendinstructie',
    "Beschrijving"=> 'Beschrijving'];
    ?>
    <!-- form inputs -->
    <div class="uk-flex uk-flex-around uk-flex-column uk-margin-small-left uk-margin-small-right uk-text-truncate ">
      <input type="text" id=<?php echo $form_ids['Titel'] ?> name="Titel" maxlength="25" value="" required >
      <input type="text" id=<?php echo $form_ids['Plaatsnaam'] ?> name="Plaatsnaam"  maxlength="50" value="" required>
      <input type="text" id=<?php echo $form_ids['Land'] ?> name="Land" maxlength="52" value="" required >
      <input type="number" id=<?php echo $form_ids['Startprijs'] ?> min="0.5" name="Startprijs" value="" required>
      <input type="number" id=<?php echo $form_ids['Verzendkosten'] ?> min="0.5" name="Verzendkosten" value="" required>

      <select id=<?php echo $form_ids['Looptijd'] ?> name="Looptijd" >
      <option value="1">1 dag</option>
      <option value="3">3 dagen</option>
      <option value="5">5 dagen</option>
      <option value="7" selected>7 dagen</option>
      <option value="10">10 dagen</option>
      </select>

      <select id=<?php echo $form_ids['Bank'] ?> name="Bank">
      <option value="ABN">ABN Ambro</option>
      <option value="AEGON">Aegon</option>
      <option value="ASN">Asn</option>
      <option value="ASR">Asr</option>
      <option value="ING">ING</option>
      <option value="KNAB">KNAB</option>
      <option value="RABO">Rabo bank</option>
      <option value="SNS">SNS Bank</option>
      </select>

      <input id=<?php echo $form_ids['Banknummer'] ?> type="text" name="Banknummer" value="" required>
    </div>
    </div>

      <script>
      //Preview van fotos
      function previewFiles() {
      var preview = document.querySelector('#preview');
      var files   = document.querySelector('input[name="fotos[]"]').files;

      function readAndPreview(file) {
        if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
          var reader = new FileReader();
          reader.addEventListener("load", function () {
            //image maken
            var image = new Image();
            //in een list item zetten
            var list =  document.createElement("li");
            image.height = 100;
            image.title = file.name;
            image.src = this.result;
            preview.appendChild( list );
            list.appendChild(image);
          }, false);
          reader.readAsDataURL(file);
        }
      }
      if (files) {
        [].forEach.call(files, readAndPreview);
      }
      }
    </script>
  </div>
  </div>
<!-- Textarea's -->
  <div class="uk-flex uk-flex-center uk-text-center uk-margin uk-flex uk-flex-wrap">
    <div class="uk-margin-right">
      <h3>Verzendinstructie</h3>
      <textarea style="resize:none" name="Verzendinstructie" id=<?php echo $form_ids['Verzendinstructie'] ?> cols="30" rows="10" ></textarea>
    </div>
    <div class="uk-margin-right uk-margin-left">
        <h3>Betaalinstructie</h3>
        <textarea style="resize:none" name="Betaalinstructie" cols="30" rows="10" ></textarea>
    </div>
    <div class="uk-margin-left">
        <h3>Beschrijving</h3>
        <textarea  style="resize:none" name="Beschrijving" id=<?php echo $form_ids['Beschrijving'] ?> cols="30" rows="10" ></textarea>
    </div>
  </div>
  <div class="uk-flex uk-flex-center padding-large">
  <a id="previewButton" class=" uk-padding-small uk-button uk-button-primary uk-button-default" type="button"> Next <br><br> <strong>Preview</strong></a>
  <div id="alert">
  </div>

</form>
</div>

<?php
  include "includes/footer.php";
  ?>
</body>
</html>

<script>

$(document).ready(function(){
  $('#previewButton').click(function (element) {
    <?php
    echo "var form_ids = [];";
    //waarden van de elementen die de ids hebben in de array uitlezen en in een andere array zetten
    foreach ($form_ids as $key => $value) {
    echo "form_ids.push(document.getElementById('$value').value);";
  }?>
  //Deze array doorgeven aan het externe bestand die geladen wordt (de preview)
    $('#alert').load("preview-item.php",{ form_ids:form_ids });
    });
});

 //als er een key is ingedrukt op de id 'toggleform'
 $( "#toggle-form" ).one("click",function (element) {
        //stuurt een request naar de url
             $('#rubrieken').load("item-aanbieden-load.php");
      });
</script>
