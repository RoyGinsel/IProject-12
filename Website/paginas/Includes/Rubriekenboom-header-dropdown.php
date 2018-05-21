<!-- search -->
<div class="uk-margin-remove">
   <!-- php pagina met rubrieken  en autocomplete-->
   <form class="uk-search uk-search-default uk-flex-inline" autocomplete="off" action="Producten.php" method="get" class="pointer">
     <div class="autocomplete">
       <?php //autocomplete id veranderd omdat hij vaker word aangeroepen
       //id wordt gebruikt in de javascript autocomplete functie
        echo "<input id='$id' class='searchbartext uk-search-input' name='rubriek' type='text' placeholder='Zoek op rubrieken'>"; ?>
      </div>
     <div class="uk-float-right ">
       <input class="submitButton" type="submit">
     </div>
   </form>
</div>

<!-- Rubrieken accordion -->
<div class="uk-padding-remove uk-height-large uk-overflow-auto uk-flex  uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2">
  <?php
  include "includes/Rubrieken-accordion.php";
?>
</div>

<!-- Javascript -->
<script type="text/javascript">
<?php
  $autoSection = "";
  foreach(sections(-1) as $value){
    foreach(sections($value['rubriekNummer'])as $sub){
      $autoSection .=  '"' . $sub['rubriekNaam'] . '",';
    }
  }
  $autoSection .= '""';
  echo "var sections = [$autoSection];";
?>
function autocomplete(inp, arr) {
  // de functie heeft 2 parameters, de input in het zoekveld en de array van strings waarop ge-autocomplete moet worden.
  //De functie wordt uitgevoerd als er wordt getypt
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      //Sluit elke lijst die geopend zijn
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      //DIV element wordt gecreerd om de list items
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //DIV is een kind va de autocomplete container
      this.parentNode.appendChild(a);

      for (i = 0; i < arr.length; i++) {
        //kijk of de item begint met de zelfde letters als er wordt ingetypt
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          //DIV element wordt gecreerd om de matching list items
          b = document.createElement("DIV");
          //Maak de matching letters BOLD
          
          b.innerHTML = "<strong> <a href='producten.php?rubriek='>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          //maak een input type dat de waarde houd die geselecteerd is
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
    var x = document.getElementsByClassName("autocomplete-items");
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
<?php echo "autocomplete(document.getElementById('$id'), sections);"; ?>
</script>
