<?php
include "includes/functies.php";
//hernoemt een rubriek als dat gedaan moet worden
if(isset($_GET['hrRubriek'])){
    renameSection($_GET['hrNaam'],$_GET['hrRubriek']);
}
//kijkt of er een rubriek verwijderd moet worden en doet dat als er geen errors komen
if(isset($_GET['vwRubriek']) && !isset($_GET['probleem']) && !isset($_GET['doorgaan'])){
    $number = $_GET['vwRubriek'];
    if(checkSubSections($number)){
        foreach(section($number) as $row){
            changeParentRubriek($number,$row['parentRubriek']);
            deleteRubriek($number);
        }
    } elseif(checkAuctions($number) && !isset($_GET['probleem']) && !isset($_GET['doorgaan'])){
        echo "ik kom hier door";
        header("location: Rubrieken-Beheer.php?vwRubriek=$number&probleem=1");
    } else {
        deleteRubriek($number);
    }
} elseif(isset($_GET['vwRubriek']) && isset($_GET['doorgaan'])){
    $number = $_GET['vwRubriek'];
    echo "in foreach";
    deleteAuctionRubriek($number);
    deleteRubriek($number);
    header("location: Rubrieken-Beheer.php");
}

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
        // maakt een error message als een rubriek veiling items onder zich heeft
        if(isset($_GET['probleem'])){
            $number = $_GET['vwRubriek'];
            echo "<div class='uk-align-center uk-width-1-2'>
            <p class='uk-align-center'>De rubriek die u wilde verwijderen heeft veilig items.<br>
            Wilt u toch doorgaan met de actie dan worden de veilig items ontbonden van dat rubriek.</p>
            <div class='uk-flex uk-flex-around uk-width-1-1'>
                <a href='Rubrieken-Beheer.php?doorgaan=1&vwRubriek=$number&iets=iets'>Ja</a>
                <a href='Rubrieken-Beheer.php'>Nee</a>
            </div>
            </div>";
        }
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
    <div class="uk-padding"></div>
    <div class="uk-padding" ></div>
</div>    
</body>
</html>

