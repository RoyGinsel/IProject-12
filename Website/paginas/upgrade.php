<?php
    session_start();
    include "functies.php";
    $crumbs = array("Activeer");
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
          <h4 class="uk-margin-remove uk-text-center">Kies verificatiemethodes: </h4>
            <input name="post_creditcardpost" type="radio" id="chose_post" value="Post" checked="checked">
              <label for="chose_post">Post</label>
              <!--If creditcard is geselecteerd weergeef de creditcard inputbox -->
          <div>
            <input type="radio" name="post_creditcardpost" value="Creditcard" id="chose_creditcard">
              <label for="chose_creditcard">Creditcard</label>
              <!-- Als creditcard geselecteerd is maak het veld required  -->
            <div class="reveal-if-active">
              <label for="creditcardnummerInvoer">Vul uw creditcard nummer in:</label>
              <input class="require-if-active uk-width-1-1 uk-form-large uk-margin-top uk-margin-bottom" id="creditcardnummerInvoer" name="creditcardnummerInvoer" type="number" placeholder="Creditcardnummer" data-require-pair="#chose_creditcard">
            </div>
          </div>
            <div class="uk-text-center checkbox uk-margin-top">
            <label><input name="post_akkoord" type="checkbox" required> U gaat akkoord</label>
          </div>
          <div>
            <input class="uk-button uk-button-primary uk-width-1-1 uk-margin-top uk-padding-remove knopje" type="Submit" name="Submit" value="Activeer verkopersaccount">
          </div>
        </div>
      </form>
     </div>
     <script>
     var makeRequired = {
       init: function() {
         // Run de functie één keer, dit om te zorgen dat als er al een button is geselecteerd wanneer de pagina laad, hij de functie niet overruled.
         this.applyConditionalRequired();
         this.bindUIActions();
       },
       bindUIActions: function() {
         // Checked of de radio buttons wanneer er op een radio button wordt geclickt
         $("input[type='radio']").on("change", this.applyConditionalRequired);
       },
       applyConditionalRequired: function() {
         // Vind de "require-if-active" class
         $(".require-if-active").each(function() {
           var el = $(this);
           // Vind de "require-pair" class
           if ($(el.data("require-pair")).is(":checked")) {
             // Indien de button is geselecteerd, maak required: true
             el.prop("required", true);
           } else {
             // Indien de button niet is geselecteerd, maak required: false
             el.prop("required", false);
           }
         });
       }
     };
     makeRequired.init();
      </script>
    </main>
    <!-- Footer -->
  <?php
    include "includes/footer.php";
  ?>
</body>
</html>
