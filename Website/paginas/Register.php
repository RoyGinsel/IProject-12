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

  <!-- registratieformulier-->

<div class="melding">
<?php

if(isset($_GET['error'])){
  if($_GET['error'] == "email"){

   echo "Email is niet goed";

  }else if($_GET['error'] == "Gebruikersnaam"){

  echo "Gebruikersnaam is niet goed ";

  };
}
?>
</div>

<form action="handler/handler.php" method="post">
  <div class="uk-form uk-width-1-1 uk-flex uk-flex-inline uk-flex-center uk-margin-large-top">
    <div class="uk-flex uk-flex-around uk-flex-column uk-height-large">
      <span>Email:</span>
      <span>Voornaam:</span>
      <span>Achternaam:</span>
      <span>Gebruikersnaam:</span>
      <span>Wachtwoord:</span>
      <span>Herhaal Wachtwoord:</span>
      <span>Adress:</span>
      <span>Adress2:</span>
      <span>Postcode:</span>
      <span>Plaats:</span>
      <span>Land:</span>
      <span>Telefoonnummer:</span>
      <span>Geboortedatum:</span>
      <span>Kies een geheimevraag:</span>
      <span>Geheimevraag antwoord:</span>
    </div>


    <div class="uk-flex uk-flex-column uk-flex-around uk-margin-large-left">
      <input type="email" name="email" maxlength="25" >
      <input type="text" name="Voornaam"  maxlength="50">
      <input type="text" name="Achternaam" maxlength="52" >
      <input type="text" name="Gebruikersnaam" maxlengt="20">
      <input type="Password" name="Wachtwoord" maxlenght="25" >
      <input type="Password" name="WachtwoordHer" maxlength="25" >
      <input type="text" name="Adres" maxlength="95">
      <input type="text" name="Adres2" maxlength="95">
      <input type="text" name="Postcode" maxlength="9">
      <input type="text" name="Plaats" maxlength="35">
      <input type="text" name="Land" maxlength="55">
      <input type="number" name="Telefoonnummer">
      <input type="date" name="Geboortedatum" max="<?php echo date("Y-m-d") ?>">
      <select class="uk-form-select" name="Geheimevraag">
        <option value="1">hoe heet je moeder</option>
        <option value="2">hoe heet je vader</option>
      </select>
      <input type="text" name="Geheimevraag" required>

    </div>


  </div>
  <div class="uk-flex uk-flex-center uk-padding-large">
<button type="submit" class="uk-button uk-button-default uk-button-primary" value="submitbutton" name="submit">Verzenden</button>
</div>
</form>


</main>
<?php
  include "includes/footer.php";
  ?>
</body>

</html>
