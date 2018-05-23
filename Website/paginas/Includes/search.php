<?php
include "../functies.php";
?>

<?php
$searchlist = "";
//Opgevangen variabele van de ajax request op Rubriekenboom-header-dropdown.php
$search = $_POST["result"];

//Als er op een ' wordt gezocht wordt de query hieronder onderbroken
$search = str_replace("'", "",$search);

//Echoen van overeenkomende namen in de db met de variabele search
foreach(query("SELECT rubriekNaam FROM tblRubriek WHERE rubriekNaam LIKE '%$search%'") as $result){
    foreach($result as $subresult){
     $searchlist.= "<li>".$subresult."</li>";
    }
}
echo $searchlist;
   ?>