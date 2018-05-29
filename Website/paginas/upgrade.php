<?php
    session_start();
    include "functies.php";
    $crumbs = array("Upgrade");
    if(isset($_GET["data"])){
      $data = htmlspecialchars($_GET["data"]);
    } else {
      $data = 1;
    }
    if($_SESSION['username'] == false){
      header('Location: index.php');
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
  <!-- Main inhoud -->
    <main class="upgradeStyle">
      <div class="uk-align-center uk-width-medium">
        <h2>Vul de volgende gegevens in:</h2>
        <form action="index.php" method="post" class="uk-panel uk-panel-box uk-form">
          <div class="uk-form-row">
            <input class="uk-width-1-1 uk-form-large uk-margin-top" name="post_bank" type="text"  placeholder="Wat is uw bank?" required>
            <input class="uk-width-1-1 uk-form-large uk-margin-top" name="post_bankrekening" type="number" placeholder="Bankrekeningnummer" required>
            <input class="uk-width-1-1 uk-form-large uk-margin-top" name="post_creditcardnumber" type="number" placeholder="Creditcardnummer" >
            <div>
                <input class="uk-button uk-button-primary uk-width-1-1 uk-margin-top uk-padding-remove knopje" type="Submit" name="Submit" value="Activeer verkopersaccount">
            </div>
          </div>
        </form>
    </main>
    <!-- Footer -->
  <?php
    include "includes/footer.php";
  ?>
</body>
</html>
