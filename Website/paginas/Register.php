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

</div>
<p class='uk-flex  uk-flex-center uk-margin-small-top uk-text-large uk-text-bold'>Inschrijfformulier</p>
<form action="handler.php" method="post">
  <div class="uk-form  uk-wid uk-width-1-1 uk-flex uk-flex-inline uk-flex-center uk-margin-medium-top">
  
    <div class="persoonsGegevens uk-flex uk-flex-around uk-flex-column uk-height-large uk-margin-small-left uk-text-nowrap">
      <span>Email:</span>
      <span>Voornaam:</span>
      <span>Achternaam:</span>
      <span>Gebruikersnaam:</span>
      <span>Wachtwoord:</span>
      <span>Herhaal Wachtwoord:</span>
      <span>Adress:</span>
      <span>AdressExtra:</span>
      <span>Postcode:</span>
      <span>Plaats:</span>
      <span>Land:</span>
      <span>Telefoonnummer:</span>
      <span>Geboortedatum:</span>
      <span>Kies Geheimevraag:</span>
      <span>Geheimevraag Antwoord:</span>
    </div>


    <div class="invoervelden uk-flex uk-flex-around uk-flex-column uk-margin-small-left uk-margin-small-right uk-text-truncate">
      <input type="email" name="email" maxlength="25" required >
      <input type="text" name="Voornaam"  maxlength="50" required>
      <input type="text" name="Achternaam" maxlength="52" required >
      <input type="text" name="Gebruikersnaam" maxlengt="20" minlenght='5' required>
      <input type="Password" name="Wachtwoord" maxlenght="25" required >
      <input type="Password" name="WachtwoordHer" maxlength="25" required >
      <input type="text" name="Adres" maxlength="95" required>
      <input type="text" name="AdresExtra" maxlength="95">
      <input type="text" name="Postcode" maxlength="9" required>
      <input type="text" name="Plaatsnaam" maxlength="35" required>
      <input type="text" name="Land" maxlength="55" required>
      <input type="number" name="Telefoonnummer" required>
      <input type="date" name="Geboortedatum"  max="<?php echo date("Y-m-d") ?>">
      <select class="uk-text-bold"  name="Geheimevraag" required>
       <!-- haalt de geheimenvraag uit de database met value -->
        <?php foreach(getQuestions() as $key => $value){ ?>

         <option value="<?php echo $value['vraagNummer'] ?>"><?php echo $value['tekstVraag'] ?></option>

          <?php  } ?>
      </select>
      <input type="text" name="Antwoordvraag" required>


    </div>
  </div>
  <div class="uk-flex uk-flex-center padding-large">
<button type="submit" class="uk-button uk-button-default uk-button-primary uk-margin-medium-top" value="submitbutton" name="submit">Verzenden</button>
</div>
<div class='uk-flex uk-flex-center uk-margin-small-top uk-text-danger'><?php if(isset($_GET['error'])){echo $Warning; }?> </div>

</form>


</main>
<?php
  include "includes/footer.php";
  ?>
</body>

</html>
