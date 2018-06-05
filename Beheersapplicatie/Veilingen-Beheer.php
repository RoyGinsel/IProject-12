<?php
include "includes/functies.php";

if(isset($_GET['vwBlokkeren'])){
  $voorwerp = $_GET['vwBlokkeren'];
    stopAuction($voorwerp);
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
<header>
  <div class="header uk-width-1-1  uk-flex uk-flex-around uk-flex-middle">
    <div>
      <h1>Veilingen beheren</h1>
      Ga naar:
      <a href="../Website/paginas/index.php" class=""><br>Hoofdsite</a>
      <br>
      <a href="User-beheer.php" class="">User beheer</a>
      <br>
      <a href="Rubrieken-beheer.php" class="">Rubrieken beheer</a>
    </div>
  </div>
</header>
<body>
  <main>
    <div class="uk-flex uk-flex-wrap uk-flex-space-around uk-width-1-1 uk-child-width-1-2 " >
        <div class="uk-padding">
            <h1>Veilingen blokkeren</h1>
            <form action="#" method="get" class="uk-flex uk-flex-column uk-child-width-1-2">
                <select name="vwBlokkeren">
                    <option value="">Niks blokkeren</option>
                    <?php
                        foreach(allAuctions() as $row){
                            echo "<option value=".$row['voorwerpNummer'].">".$row['titel']." | Omschrijving: ".$row['beschrijving']." | Voorwerpnummer: ".$row['voorwerpNummer']."</option>";
                        };
                    ?>
                </select>
                <input class="uk-text-danger" type="submit" value="Blokkeren">
            </form>
        </div>
  </main>
</body>
</html>
