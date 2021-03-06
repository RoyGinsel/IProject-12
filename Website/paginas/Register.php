<?php
session_start();
include "functies.php";
$crumbs = array("Register");
if(isset($_GET["data"])){
  $data = htmlspecialchars($_GET["data"]);
} else {
  $data = 1;
}
if(isset($_SESSION['username'])){

  header('Location: index.php');
}
$warningEmail = "";
$warningUsername = "";
$warningPassword = "";
$warningNumber = "";
// geeft een foutmelding op basis van of de gebruikersnaam  / email  al bestaat of wachtwoord niet het zelfde is.
if(isset($_GET['error'])){
  switch($_GET['error']){
    case "Email":
      $warningEmail = "Emailadres is al in gebruik.";
    break;
    case "Gebruikersnaam":
      $warningUsername = "Gebruikersnaam is al in gebruik.";
    break;
      case "Wachtwoord":
      $warningPassword = 'Wachtwoord is niet het zelfde';
      break;
      case "telefoonNummer":
        $warningNumber = 'Telefoonnummer is geen geldig nummer';
        break;
    }
}
 ?>

 <!DOCTYPE HTML>
<html lang="nl" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inschrijven</title>
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
  <!-- registratieformulier-->
<p class='uk-flex  uk-flex-center uk-margin-small-top uk-text-large uk-text-bold'>Inschrijfformulier</p>
<form action="handler.php" method="post">
  <div class="uk-form  uk-wid uk-width-1-1 uk-flex uk-flex-inline uk-flex-center uk-margin-medium-top">
    <div class="persoonsGegevens uk-flex uk-flex-around uk-flex-column uk-height-large uk-margin-small-left uk-text-nowrap">
      <span>Email:*</span>
      <span>Voornaam:*</span>
      <span>Achternaam:*</span>
      <span>Gebruikersnaam:*</span>
      <span>Wachtwoord:*</span>
      <span>Herhaal Wachtwoord:*</span>
      <span>Adres:*</span>
      <span>AdresExtra:</span>
      <span>Postcode:*</span>
      <span>Plaats:*</span>
      <span>Land:*</span>
      <span>Telefoonnummer:*</span>
      <span>Geboortedatum:*</span>
      <span>Kies Geheimevraag:*  </span>
      <span>Geheimevraag Antwoord:* </span>
      <span>Ik ga akkoord met het privacybeleid. *</span>
    </div>
    <!-- Formuliervelden, value is leeg of gevuld met post waarden  als de gebruiker niet goed is ingelogd zodat gegevens gevuld blijven-->
    <div class="invoervelden uk-flex uk-flex-around uk-flex-column uk-margin-small-left uk-margin-small-right uk-text-truncate">
      <input type="email" name="email" maxlength="25" value = "<?php if(isset($_SESSION['email']) && $warningEmail == "" ){echo $_SESSION['email']; }  ?>"  placeholder = "<?php echo $warningEmail; ?>" required >
      <input type="text" name="Voornaam"  maxlength="50" value = "<?php if(isset($_SESSION['voornaam'])){echo $_SESSION['voornaam']; }  ?>"  required>
      <input type="text" name="Achternaam"  value = "<?php if(isset($_SESSION['achternaam'])){echo $_SESSION['achternaam']; } ?>" maxlength="52" required >
      <input type="text" name="Gebruikersnaam" value = "<?php if(isset($_SESSION['gebruikersNaam']) && $warningUsername == "" ){echo $_SESSION['gebruikersNaam']; }  ?>" maxlength="20" placeholder="<?php echo  $warningUsername; ?>" minlenght='5'required>
      <input type="Password" name="Wachtwoord"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet teminste 8 karakters , één nummer en één hoofdletter bevatten" placeholder="<?php echo $warningPassword; ?>" maxlength="25" required >
      <input type="Password" name="WachtwoordHer" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet teminste 8 karakters , één nummer en één hoofdletter bevatten" maxlength="25" required >
      <input type="text" name="Adres" maxlength="95" value = "<?php if(isset($_SESSION['adres'])){echo $_SESSION['adres']; }  ?>"   required>
      <input type="text" name="AdresExtra" value = "<?php if(isset($_SESSION['adresExtra'])){echo $_SESSION['adresExtra']; } ?>" maxlength="95">
      <input type="text" name="Postcode" value = "<?php if(isset($_SESSION['postcode'])){echo $_SESSION['postcode']; } ?>" maxlength="9" required>
      <input type="text" name="Plaatsnaam" value = "<?php if(isset($_SESSION['postcode'])){echo $_SESSION['plaatsNaam']; } ?>" maxlength="35" required>
      <input type="text" name="Land"  value = "<?php if(isset($_SESSION['land'])){echo $_SESSION['land']; } ?>" maxlength="55" required>
      <input type="number" class='uk-width-medium'  value ="<?php if(isset($_SESSION['telefoonNummer']) && $warningNumber == ""){echo $_SESSION['telefoonNummer']; } ?>" name="Telefoonnummer"  placeholder="<?php echo $warningNumber; ?>" required>
      <input type="date" name="Geboortedatum" value = "<?php if(isset($_SESSION['geboorteDag'])){echo $_SESSION['geboorteDag']; } ?>"  max="<?php echo date("Y-m-d") ?>">
      <select class="uk-text-bold"  name="Geheimevraag" required>
       <!-- haalt de geheimenvraag uit de database met value -->
        <?php foreach(getQuestions() as $key => $value){ ?>
         <option value="<?php echo $value['vraagNummer'] ?>"><?php echo $value['tekstVraag'] ?></option>
          <?php  } ?>
      </select>
      <input type="text" name="Antwoordvraag" maxlength="25"  required >
      <input class="uk-checkbox"  type="checkbox" name="voorwaarden" value = "agreed" required>
    </div>
   </div>
  <div class="uk-flex uk-flex-center padding-large">
    <button type="submit" class="uk-button uk-button-default uk-button-primary uk-margin-medium-top" value="submitbutton" name="submit">Verzenden</button>
  </div>
</form>
</main>
<?php
  include "includes/footer.php";
  ?>
</body>
</html>
