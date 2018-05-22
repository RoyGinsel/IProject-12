<?php
    session_start();
    include "functies.php";
    $crumbs = array("Inloggen");
    if(isset($_GET["data"])){
      $data = htmlspecialchars($_GET["data"]);
    } else {
      $data = 1;
    }
    // Wanneer wachtwoord of username verkeerd is ingevoerd maakt hij een error message
    $error="";
    if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
              $error = "Wrong Username / Password";
    }
 ?>
<html lang="nl" dir="ltr">
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
  <!-- Header -->
  <?php
    include "includes/header.php";
  ?>
  <!-- Main inhoud -->
    <main class="signIn">
    <!-- Inlogveld  -->
      <div class="uk-align-center uk-width-medium">
        <h1>Inloggen:</h1>
        <!--Echo'ed de warning message  -->
        <p class="uk-text-danger"><?php echo $error; ?></p>
        <form action="index.php" method="post" class="uk-panel uk-panel-box uk-form">
          <div class="uk-form-row">
            <input class="uk-width-1-1 uk-form-large" name="post_gebruikersnaam" type="text"  placeholder="Gebruikersnaam" required>
          </div>
          <div class="uk-form-row">
            <input class="uk-width-1-1 uk-form-large uk-margin-top" name="post_wachtwoord" type="password" placeholder="Wachtwoord" required>
          </div>
          <div class="uk-flex uk-flex-inline uk-width-1-1 uk-child-width-1-2  uk-margin-top">
            <div class="uk-form-row uk-text-small">
              <input class="uk-padding-remove" type="checkbox" name="checkbox" value="checkbox">Remember me
              <a class="uk-link" href="#">Wachtwoord vergeten?</a>
            </div>
            <div class="uk-form-row">
              <input class="uk-button uk-button-primary uk-width-1-1 uk-padding-remove knopje" type="Submit" name="Submit" value="LOG IN">
            </div>
          </div>
        </form>
        <!--Scheidende tekst ("of")  -->
        <div class="orText">
          <span>Of</span>
        </div>
        <!--Registreer knop  -->
        <form class="" action="Register.php">
          <input class="uk-button uk-button-primary uk-width-1-1 uk-padding-remove knopje" type="Submit" name="Submit" value="registreren">
        </form>
      </div>
    </main>
    <!-- Footer -->
  <?php
    include "includes/footer.php";
  ?>
</body>
</html>
