<?php
session_start();
include "functies.php";
$crumbs = array("Producten");
if(isset($_GET["data"]))
{
    $data = $_GET["data"];
} else {
  $data = 1;
}

if(isset($_GET["rubriek"]))
{
  $rubriek = $_GET["rubriek"];
}else{
  $rubriek = "";
}
$pagination = "<ul class='uk-pagination'>";
if($data != 1){
  $prev = $data-1;
  $pagination .= "<li><a href='producten.php?data=1'><<</span></a></li>
                  <li><a href='producten.php?data=$prev&rubriek=$rubriek'><</a></li>";
}
if($data == 2){
  $pagination .= "<li><a href='producten.php?data=1'>1</a></li>";
} elseif($data > 2){
  $prev1 = $data - 1;
  $prev2 = $data - 2;
  $pagination .= "<li><a href='producten.php?data=$prev2&rubriek=$rubriek'>$prev2</a></li>
                  <li><a href='producten.php?data=$prev1&rubriek=$rubriek'>$prev1</a></li>";
}
$next1 = $data+1;
$next2 = $data+2;
$pagination .= "<li class='uk-active'><span>$data</span></li>
                <li><a href='producten.php?data=$next1&rubriek=$rubriek'>$next1</a></li>
                <li><a href='producten.php?data=$next2&rubriek=$rubriek'>$next2</a></li>
                <li><a href='producten.php?data=$next1&rubriek=$rubriek'>></a></li>
                </ul>";


// zoek query met data invoeren om volgende producten te krijgen
?>
<!DOCTYPE html>
<html lang="en">
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
<main>
<div class="uk-float-left uk-width-1-4@s uk-width-1-1 uk-margin uk-child-width-1-1 uk-text-small uk-text-large@m">
  <button class="uk-button uk-button-default " type="button" uk-toggle="target: #toggle-usage"><h5>
  Rubrieken-filter</h5></button>
  <div class="uk-child-width-auto" id="toggle-usage">
      <div class="uk-flex-column uk-margin uk-grid-small uk-child-width-auto uk-grid uk-grid-divider">
        <!-- search -->
        <div class="uk-margin-remove">
           <!-- php pagina met rubrieken -->
            <form class="uk-search uk-search-default" autocomplete="off" action="Producten.php">
              <div class="auto-complete uk-flex-inline">
                <input id="auto-complete" class="uk-search-input" type="text" name="" value="Search">
                <input type="submit" name="Zoek" value="Zoek">
              </div>
                </form>
              </div>
            </div>

    <ul class="uk-list-striped uk-list" uk-accordion="multiple: true">
        <li>
            <a class="uk-accordion-title" href="#">Item 1</a>
            <div class="uk-accordion-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#">Item 2</a>
            <div class="uk-accordion-content">
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#">Item 3</a>
            <div class="uk-accordion-content">
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
            </div>
        </li>
    </ul>
  </div>
</div>



  <div class="uk-flex uk-flex-center uk-width-3-4@s uk-width-1-1">
<div class=" uk-child-width-auto uk-width-5-6">

  <nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
      <h3>Hoofdrubriek</h3>
  </div>
  <div class="uk-navbar-right">
    <h3>Subrubriek</h3>
  </div>
  </nav>

  <ul class="uk-list-striped uk-list" uk-accordion="multiple: true">
      <li class="uk-open">
          <a class="uk-accordion-title" href="#">Item 1</a>
          <div class="uk-accordion-content uk-overflow-auto">
            <table class="uk-table uk-table-middle uk-table-divider">
    <thead>
      <tr>
          <th class="uk-table-shrink">Product</th>
          <th class="uk-table-expand uk-visible@s">Omschrijving</th>
          <th class="uk-width-small uk-visible">Prijs</th>
          <th class="uk-table-shrink uk-text-nowrap"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      //gegevens halen uit de database en in tabel body zetten

      $lijst = "";
        foreach (populaireitems() as $waarde) {
       $lijst .= '
        <tr>
            <td><img class="uk-preserve-width uk-border-rounded " src=../media/Hamburgermenu.png width="80" alt="">
            <h3 class="uk-text-top uk-margin-remove uk-text-bold uk-text-small">'.$waarde['titel'].'</h3></td>
            <td class="uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate">
                <h4 class="uk-text-small">'.$waarde['beschrijving'].'</h4>
            </td>
            <td class="uk-visible">'.$waarde['bodBedrag'].'</td>
            <td><button class="uk-button uk-button-default" type="button" href="#">Ga naar bieding</button></td>

        </tr>';
      }
        echo $lijst;
        ?>
    </tbody>
  </table>
  </div>
      </li>
      <li>
          <a class="uk-accordion-title" href="#">Item 2</a>
          <div class="uk-accordion-content">
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
          </div>
      </li>
      <li>
          <a class="uk-accordion-title" href="#">Item 3</a>
          <div class="uk-accordion-content">
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
          </div>
      </li>
  </ul>
<h3>DIT IS EEN BLOK</h3>

<div class="uk-flex uk-flex-center">
<?php echo $pagination ?>
</div>
</div>
</div>

</main>
<?php
  include "includes/footer.php";
  ?>

</body>
</html>
