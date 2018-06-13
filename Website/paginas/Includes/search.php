<?php
include "../functies.php";
?>

<?php
$searchlist = "";
//Opgevangen variabele van de ajax request op Rubriekenboom-header-dropdown.php
$search = $_POST["result"];

//Als er op een ' wordt gezocht wordt de query hieronder onderbroken
$search = str_replace("'", "",$search);
$search = "%".$search."%";

//Echoen van overeenkomende namen in de db met de variabele search
foreach(preparedQuery("SELECT c.rubriekNaam,c.rubriekNummer, p.rubriekNaam as parentNaam
                    from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
                    WHERE c.rubriekNaam LIKE :search Order by c.rubriekNaam ASC",['search' => $search]) as $result){
                            $searchlist.= "<li> <strong>".$result['rubriekNummer']. ":".$result['rubriekNaam']."</strong> Pr: ".$result['parentNaam']."</li>";
                            
                    }
echo $searchlist;
   ?>