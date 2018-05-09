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
<div class="uk-clearfix">
<div class="uk-float-left uk-width-1-4@s uk-width-1-1 uk-margin uk-child-width-1-1 uk-text-small uk-text-large@m">
  <button class="uk-button uk-button-default " type="button" uk-toggle="target: #toggle-usage"><h5>
  Rubrieken-filter</h5></button>
  <div class="uk-child-width-auto " id="toggle-usage">
      <div class="uk-flex-center uk-margin uk-grid-small uk-child-width-auto uk-grid ">
        <!-- search -->
           <!-- php pagina met rubrieken -->
            <form class="uk-search uk-search-default uk-flex-inline" autocomplete="off" action="Producten.php">
              <div class="autocomplete">
                <input id="myInput" class="uk-search-input" type="search" placeholder="Zoek op rubrieken">
              </div>
              <div class="uk-float-right ">
              <input class="uk-button" type="submit">
              </div>
                </form>
            </div>
    <?php
    include "includes/Rubrieken-accordion.php"
  ?>
  </div>
</div>



  <div class="uk-flex uk-flex-center uk-width-3-4@s uk-width-1-1">
<div class=" uk-child-width-auto uk-width-5-6">

  <nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
      <h3>Hoofdrubriek</h3>
  </div>
  <div class="uk-position-center">
    <span uk-icon="icon: triangle-right; ratio: 2"></span>
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
  </ul>
<div class="uk-flex uk-flex-center">
<?php echo $pagination ?>
</div>
</div>
</div>
</div>

</main>
<?php
  include "includes/footer.php";
  ?>

</body>
</html>

<script type="text/javascript">
var countries = ["Afghanistan","Albania","Algeria"];

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items ");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}

autocomplete(document.getElementById("myInput"), countries);

</script>
