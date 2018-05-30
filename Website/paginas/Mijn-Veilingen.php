<?php
session_start();
$crumbs = array('Mijn-Veilingen');
include "functies.php";
function allSections(){
        return Query("SELECT c.rubriekNaam, c.rubriekNummer, p.rubriekNaam as parentNaam
                    from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
                    order by rubriekNaam asc");
    }
//veranderen! C:
// if(isset($_SESSION['username'])){

//     header('Location: index.php');
  
//   }
  
  // geeft een foutmelding op basis van of de gebruikersnaam  / email  al bestaat of wachtwoord niet het zelfde is.
  if(isset($_GET['error'])){
    switch($_GET['error']){
  
      case "Email":
        $Warning = "Emailadres is al in gebruik.";
      break;
  
      case "Gebruikersnaam":
        $Warning = "Gebruikersnaam is al in gebruik.";
      break;
  
      case "Wachtwoord":
        $Warning = "Wachtwoord is niet ingevuld of niet het zelfde.";
        break;
      }
    }
    if (isset($_POST['Titel'])){
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
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mijn veilingen</title>
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
<button href="#toggle-animation" class=" uk-flex  uk-align-center uk-button uk-button-default" type="button" 
  uk-toggle="target: #toggle-animation; animation: uk-animation-fade">Item aanbieden</button>
<div id="toggle-animation" class="uk-card uk-card-default uk-card-body uk-margin-small">

<form action="Mijn-Veilingen.php" method="post" enctype="multipart/form-data">
  <div class="uk-form  uk-wid uk-width-1-1 uk-flex uk-flex-inline uk-flex-center uk-margin-medium-top">
  <select class="uk-form-select" name="Rubriekaanbieden[]" multiple>
                <?php
                    foreach(allSections() as $row){
                        echo "<option value=".$row['rubriekNummer'].">".$row['rubriekNaam']." Pr.".$row['parentNaam']."</option>";
                    }
                ?>
            </select>
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
$form_ids = ["Titel" => "titel",
"Plaatsnaam" => "plaatsnaam",
"Land" => "land",
"Startprijs" => "startprijs",
"Verzendkosten" => "verzendkosten",
"Looptijd" =>"looptijd",
"Bank" => "bank",
 "Banknummer" => "banknummer",
 "foto1" => "foto1",
 "foto2" => "foto2",
 "foto3" => "foto3",
 "foto4" => "foto4",
 "Verzendinstructie" => 'Verzendinstructie',
  "Beschrijving"=> 'Beschrijving'];
?>
    <div class="uk-flex uk-flex-around uk-flex-column uk-margin-small-left uk-margin-small-right uk-text-truncate">
      <input type="text" id=<?php echo $form_ids['Titel'] ?> name="Titel" maxlength="25" value="Titel" required >
      <input type="text" id=<?php echo $form_ids['Plaatsnaam'] ?> name="Plaatsnaam"  maxlength="50" value="Plaatsnaam" required>
      <input type="text" id=<?php echo $form_ids['Land'] ?> name="Land" maxlength="52" value="LAND" required >
      <input type="number" id=<?php echo $form_ids['Startprijs'] ?> name="Startprijs" maxlengt="20" value="10.00" required>
      <input type="number" id=<?php echo $form_ids['Verzendkosten'] ?> name="Verzendkosten" maxlength="95" value="0.00" required>
      
      <select id=<?php echo $form_ids['Looptijd'] ?> name="Looptijd" >
      <option value="1">1 dag</option>
      <option value="3">3 dagen</option>
      <option value="5">5 dagen</option>
      <option value="7">7 dagen</option>
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

      <input id=<?php echo $form_ids['Banknummer'] ?> type="number" name="Banknummer" value="20389456" required>
      
      <script>
          function previewFiles() {
var preview = document.querySelector('#preview');
var files   = document.querySelector('input[name="test"]').files;

function readAndPreview(file) {
  // Make sure `file.name` matches our extensions criteria
  if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
    var reader = new FileReader();
    reader.addEventListener("load", function () {
      var image = new Image();
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
  <div class="uk-flex uk-flex-center uk-text-center uk-margin">
  <input id=<?php echo $form_ids['foto1'] ?> type="file" id="#imgInp1" class="a" src="" name=<?php echo $form_ids['foto1'] ?>/>
      <input id=<?php echo $form_ids['foto2'] ?> type="file" id="#imgInp2" class="a" src="" name=""/>
      <input id=<?php echo $form_ids['foto3'] ?> type="file" id="#imgInp3" class="a" src="" name=""/>
      <input id=<?php echo $form_ids['foto4'] ?> type="file" id="#imgInp4" class="a" src="" name=""/> 
</div>
      <div class="uk-flex uk-flex-center uk-text-center uk-margin">
  <div class="uk-margin-right">
    <h3>Verzendinstructie</h3>
    <textarea style="resize:none" name="Verzendinstructie" id=<?php echo $form_ids['Verzendinstructie'] ?> cols="30" rows="10" >sdjkafoasidjf</textarea>
</div>
<div class="uk-margin-right uk-margin-left">
    <h3>Betaalinstructie</h3>
    <textarea style="resize:none" name="Betaalinstructie" cols="30" rows="10" >sdjkafoasidjf</textarea>
</div>
<div class="uk-margin-left">
    <h3>Beschrijving</h3>
    <textarea  style="resize:none" name="Beschrijving" id=<?php echo $form_ids['Beschrijving'] ?> cols="30" rows="10" >saklfjapifjosakdpfjpi9w</textarea>
</div>
  </div>
  <div class="uk-flex uk-flex-center padding-large">
  <a id="1" class="uk-button">Next <br> Preview</a>
  <div id="alert">
  </div>


<script>
$(document).ready(function(){
  $('a').click(function (element) {
    <?php 
    echo "var form_ids = [];";
    foreach ($form_ids as $key => $value) {
    echo "form_ids.push(document.getElementById('$value').value);";
  }?> 
    $('#alert').load("preview-item.php",{ form_ids:form_ids });
    });
});
</script>

</div>
<div class='uk-flex uk-flex-center uk-margin-small-top uk-text-danger'>
<?php if(isset($_GET['error'])){echo $Warning; }?> 
</div>

</form>
</div>

<?php
  include "includes/footer.php";
  ?>
</body>
</html>