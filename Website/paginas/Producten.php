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

  //filteren op prijs door het in een sessie te gooien zodat het ook op pagination werkt
  $filter = "";
  if(isset($_POST['maximumprijs'])){
    $_SESSION['minimumprijs'] = $_POST['minimumprijs'];
    $_SESSION['maximumprijs'] = $_POST['maximumprijs'];
  }
  //String van een where clause om te filteren,
  //bepaald of er al geboden is of niet en kiest dan tussen startprijs of hoogste bod
  if(isset($_SESSION['maximumprijs']) ){
    $filter = "AND (b.bodBedrag is not NULL AND b.bodBedrag BETWEEN ". $_SESSION['minimumprijs'] ." AND ".  $_SESSION['maximumprijs']  .")
    OR (b.bodBedrag is NULL AND startPrijs BETWEEN ". $_SESSION['minimumprijs']." AND ".  $_SESSION['maximumprijs'] .")";
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
  ?>
  <main>
  <div class="uk-clearfix">
    <div class="uk-float-left uk-width-1-4@s uk-width-1-1 uk-margin uk-child-width-1-1 uk-text-small uk-text-large@m">
    <!-- toggle zoekfilter -->
      <button class="uk-button uk-button-default " type="button" uk-toggle="target: #toggle-usage">
        <h5>Zoek-filter</h5>
      </button>
      <!-- toggle content -->
      <div class="uk-child-width-auto " id="toggle-usage">
        <div class="uk-flex-center uk-margin">
        <!-- Prijs filteren -->
          <div class="uk-margin-bottom"><h2>Kies een prijsrange</h2></div>
          <!-- form met sliders -->
          <form action="producten.php" method="post">
          <input id="maximumprijsfilter" type="number" placeholder="Kies een maximumprijs" >
          <a id="buttonprijsfilter" class="uk-button uk-button-primary uk-text-middle">Kies</a>
          <!-- slider voor minimumprijs -->
          <div class="uk-padding-remove">
          <input id="minimumprijs" class="uk-range" type="range" name="minimumprijs" min="0" max="" step="0.1">
          <script>
          //waarde aflezen van de slider
          var minslider = document.getElementById('minimumprijs').value;
          //als er op de slider wordt geklikt
            $('#minimumprijs').click(function (element) {
              //toekennen waarde aan variabele
            minslider = document.getElementById('minimumprijs').value;
            //max attribute die waarde geven van de variabele
            document.getElementById("minimumprijs").max = maxslider;
            //html schrijven van de waarde op de div hieronder met het id "minprijs"
            document.getElementById("minprijs").innerHTML =  "<h4> Minimale prijs: "+ minslider +"</h4>" ; });
          </script> <span id="minprijs"><h4> Minimale prijs:</h4></span>

          <!-- slider voor maximumprijs -->
          <input id="maximumprijs" class="uk-range uk-padding-remove" type="range" name="maximumprijs" min="" max="" step="0.1">
          <!-- Js werkt hetzelfde als bij de minimumprijs -->
          <script> var maxslider = document.getElementById('maximumprijs').value; var maxprijs;
            $('#maximumprijs').click(function (element) {
            maxslider = document.getElementById('maximumprijs').value;
            document.getElementById("maximumprijs").min = minslider;
            document.getElementById("maxprijs").innerHTML =  "<h4> Maximale prijs: "+ maxslider +"</h4>" ; });
            //Als er op de button met de id buttonprijsfilter wordt gedrukt
                      $('#buttonprijsfilter').click(function (element) {
                        //waarde afgelezen van input naast de button
                        maxprijs = document.getElementById("maximumprijsfilter").value;
                        //geef het attribuut max de waarde van maxprijs
                        $("#maximumprijs").attr("max", maxprijs);});
          </script> <span id="maxprijs"><h4> Maximale prijs:</h4> </span>
          <button type="submit" class="uk-button uk-width-1-1 uk-button-default uk-button-primary uk-margin-medium-top" name="submit">Zoeken</button>
          </form>
          </div>
      </div>
      <?php
      //rubriekaccordion
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
            } else{
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
                  } else{
                    $section = "";
                  }
                  $lijst = "";
                  $prijs;
                  $items = items($section, $filter);
                  for($i = 0; $i < 5;$i++){
                    $count = $i;
                    if(isset($_GET['data'])){
                      $count = $i + ($_GET['data']-1)*5;
                    }
                    if(isset($items[$count]['bodBedrag'])){
                      $prijs = $items[$count]['bodBedrag'];
                    } else {
                      $prijs = $items[$count]['startPrijs'];
                    }
                    //items opgehaald van database
                    $lijst .= "
                    <tr>
                    <td><img class='uk-preserve-width uk-border-rounded' src=../media/Hamburgermenu.png width='80' alt=''>
                    <h3 class='uk-text-top uk-margin-small-left uk-margin-remove-top uk uk-text-bold uk-text-small'>".$items[$count]['titel']."</h3></td>
                    <td class='uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate'>
                    <h4 class='uk-text-small'>".$items[$count]['beschrijving']."</h4>
                    </td>
                    <td class='uk-visible'>€ ".$prijs."</td>
                    <td class=''><a class='button-mobile uk-button uk-text-small' type='button' href='detailpagina.php?item=".$items[$count]['voorwerpNummer']."'>Ga naar bieding</a></td>
                    </tr>";
                  }
                  // foreach (items($section, $filter) as $waarde) {
                  //   if(isset($waarde['bodBedrag'])){
                  //     $prijs = $waarde['bodBedrag'];
                  //   } else {
                  //     $prijs = $waarde['startPrijs'];
                  //   }
                  //   //items opgehaald van database
                  //   $lijst .= "
                  //   <tr>
                  //   <td><img class='uk-preserve-width uk-border-rounded' src=../media/Hamburgermenu.png width='80' alt=''>
                  //   <h3 class='uk-text-top uk-margin-small-left uk-margin-remove-top uk uk-text-bold uk-text-small'>".$waarde['titel']."</h3></td>
                  //   <td class='uk-visible@s uk-text-break uk-text-nowrap uk-text-truncate'>
                  //   <h4 class='uk-text-small'>".$waarde['beschrijving']."</h4>
                  //   </td>
                  //   <td class='uk-visible'>€ ".$prijs."</td>
                  //   <td class='productenMobile'><a class='uk-button uk-text-small' type='button' href='detailpagina.php?item=".$waarde['voorwerpNummer']."'>Ga naar bieding</a></td>
                  //   </tr>";
                  // }
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
