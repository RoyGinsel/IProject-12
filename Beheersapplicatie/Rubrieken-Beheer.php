<?php
include "includes/functies.php";

if(isset($_GET['hrRubriek'])){
    renameSection($_GET['hrNaam'],$_GET['hrRubriek']);
}
// if(isset($_GET['vwRubriek'])){
//     $number = $_GET['vwRubriek'];
//     if(checkSubSection($number)){
        
//     } elseif(checkAuctions($number)){

//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="../Website/css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
    <script type="text/javascript" src="../Website/css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../Website/css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="../Website/css/style.css">
</head>
<body>
    <?php
        include "includes/header.php";
    ?>
<div class="uk-flex uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2" >
    <div class="uk-padding">
        <h1>Verwijderen</h1>
        <form action="" method="get" class="uk-flex uk-flex-column uk-child-width-1-2">
            <select name="vwRubriek">
                <option value="">Niks verwijderen</option>
                <?php
                    foreach(allSections() as $row){
                        echo "<option value=".$row['rubriekNummer'].">".$row['rubriekNaam']." Pr.".$row['parentNaam']."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="uitvoeren">
        </form>
    </div>
    <div class="uk-padding">
        <h1>Hernoemen</h1>
        <form action="" method="get" class="uk-flex uk-flex-column uk-child-width-1-2">
            <select name="hrRubriek">
                <option value="">Niks Hernoemen</option>
                <?php
                    foreach(allSections() as $row){
                        echo "<option value=".$row['rubriekNummer'].">".$row['rubriekNaam']." Pr.".$row['parentNaam']."</option>";
                    }
                ?>
            </select>
            <input type="text" name="hrNaam" placeholder="Nieuwe naam">
            <input type="submit" value="uitvoeren">
        </form>
    </div>
    <div class="uk-padding">iets voor de toekomst</div>
    <div class="uk-padding"  >iets anders voor de toekomsts</div>
</div>    
</body>
</html>

