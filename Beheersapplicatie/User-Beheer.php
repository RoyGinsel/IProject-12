<?php

include "includes/functies.php";

$allUsers = getUsers();




?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gebruiker Beheer</title>
    <script type="text/javascript" src="../Website/css/uikit-3.0.0-beta.42/dist/js/uikit.min.js"></script>
    <script type="text/javascript" src="../Website/css/uikit-3.0.0-beta.42/dist/js/uikit-icons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../Website/css/uikit-3.0.0-beta.42/dist/css/uikit.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="../Website/css/style.css">
</head>
<body>      
    <div class="header uk-width-1-1 uk-height-medium uk-flex uk-flex-around uk-flex-middle">
        <div>
            <h1>Gebruiker Beheer</h1> 
            Ga naar:
            <a href="../Website/paginas/index.php">Hoofd site</a></br>
            Ga naar:
            <a href="Rubrieken-Beheer.php">Rubriekenbeheer</a>
       </div>
     </div>
     <?php

    if(isset($_GET['selectUser'])){
        blockUser($_GET['selectUser']);

        echo ' <div class="uk-alert-primary uk-align-center uk-width-1-2" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>Gebruiker is met succes geblokkeerd</p>
        </div>';
        header('location: ./user-beheer.php');
    }
    ?>

   <div class="uk-flex uk-flex-center" >
    <div class="uk-padding">
        <H3 class="uk-text-right">Blokkeren van gebruiker</H3>
        <form action="" method="get" class="uk-flex uk-flex-column uk-form-width-medium">
            <select name = "selectUser" class="uk-margin-bottom uk-select">
                <option value="">Kies een gebruiker</option>
                <?php
                foreach($allUsers as $user => $key){

             echo '<option value="'.$key['gebruikersNaam'].'">'.$key['gebruikersNaam'].'</option>';

                }

                ?>
            </select>
            <label><input class="uk-checkbox uk-margin-small-top uk-margin-bottom" type="checkbox" name="submit" Required><span class=" uk-margin-left uk-text-danger">Bevestig Keuze</span></label>
            <input type="submit" value="Blokkeren">
        </form>
    </div>




</body>
</html>

