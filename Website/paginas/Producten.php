<?php
  session_start();
  include "functies.php";
  $crumbs = array("Producten");
  if(isset($_GET["data"])){
    $data = htmlspecialchars($_GET["data"]);
  } else {
    $data = 1;
  }
  $section;
  if(isset($_GET["rubriek"])){
    $section = htmlspecialchars($_GET["rubriek"]);
  }else{
    $section = "";
  }
  $pagination = "<ul class='uk-pagination'>";
  if($data != 1){
    $prev = $data-1;
    $pagination .= "<li><a href='producten.php?data=1'><<</span></a></li>
                    <li><a href='producten.php?data=$prev&rubriek=$section'><</a></li>";
  }
  if($data == 2){
    $pagination .= "<li><a href='producten.php?data=1'>1</a></li>";
  } elseif($data > 2){
    $prev1 = $data - 1;
    $prev2 = $data - 2;
    $pagination .= "<li><a href='producten.php?data=$prev2&rubriek=$section'>$prev2</a></li>
                    <li><a href='producten.php?data=$prev1&rubriek=$section'>$prev1</a></li>";
  }
  $next1 = $data+1;
  $next2 = $data+2;
  $pagination .= "<li class='uk-active'><span>$data</span></li>
                  <li><a href='producten.php?data=$next1&rubriek=$section'>$next1</a></li>
                  <li><a href='producten.php?data=$next2&rubriek=$section'>$next2</a></li>
                  <li><a href='producten.php?data=$next1&rubriek=$section'>></a></li>
                  </ul>";
  // zoek query met data invoeren om volgende producten te krijgen
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
  ?>
  <main>
  <div class="uk-clearfix">
    <div class="uk-float-left uk-width-1-4@s uk-width-1-1 uk-margin uk-child-width-1-1 uk-text-small uk-text-large@m">
      <button class="uk-button uk-button-default " type="button" uk-toggle="target: #toggle-usage">
        <h5>Rubrieken-filter</h5>
      </button>
      <div class="uk-child-width-auto " id="toggle-usage">
        <div class="uk-flex-center uk-margin uk-grid-small uk-child-width-auto uk-grid ">
      </div>
      <?php
        include "includes/Rubrieken-accordion.php";
      ?>
    </div>
  </div>

  <div class="uk-flex uk-flex-center uk-width-3-4@s uk-width-1-1">
    <div class=" uk-child-width-auto uk-width-5-6">
      <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
          <?php
            if(isset($_GET["rubriek"])){
              $section = htmlspecialchars($_GET["rubriek"]);
            }else{
              $section = "";
            }
            echo '<h3>'. $section.'</h3>';
          ?>
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
                  $section;
                  if(isset($_GET["rubriek"])){
                    $section = htmlspecialchars($_GET["rubriek"]);
                  }else{
                    $section = "";
                  }
                  $lijst = "";
                  $prijs;
                  foreach (items($section) as $waarde) {
                    if(isset($waarde['bodBedrag'])){
                      $prijs = $waarde['bodBedrag'];
                    } else {
                      $prijs = $waarde['startPrijs'];
                    }

                    $lijst .= "
                    <tr>
                    <td><img class='uk-preserve-width uk-border-rounded' src=../media/Hamburgermenu.png width='80' alt=''>
                    <h3 class='uk-text-top uk-margin-small-left uk-margin-remove-top uk uk-text-bold uk-text-small'>".$waarde['titel']."</h3></td>
                    <td class='uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate'>
                    <h4 class='uk-text-small'>".$waarde['beschrijving']."</h4>
                    </td>
                    <td class='uk-visible'>€ ".$prijs."</td>
                    <td class='productenMobile'><a class='uk-button uk-text-small' type='button' href='detailpagina.php?item=".$waarde['voorwerpNummer']."'>Ga naar bieding</a></td>
                    </tr>";
                  }
                  echo $lijst;
                ?>
              </tbody>
            </table>
          </div>
        </li>
      </ul>
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
