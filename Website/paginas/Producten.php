<?php
session_start();
$crumbs = array("Producten");
if(isset($_GET["data"]))
{
    $data = $_GET["data"];
}else {
  $data = 1;
}
$pagination = "<ul class='uk-pagination'>";
if($data != 1){
  $prev = $data-1;
  $pagination .= "<li><a href='producten.php?data=1'><<</span></a></li>
                  <li><a href='producten.php?data=$prev'><</a></li>";
}
if($data == 2){
  $pagination .= "<li><a href='producten.php?data=1'>1</a></li>";
} elseif($data > 2){
  $prev1 = $data - 1;
  $prev2 = $data - 2;
  $pagination .= "<li><a href='producten.php?data=$prev2'>$prev2</a></li>
                  <li><a href='producten.php?data=$prev1'>$prev1</a></li>";
}
$next1 = $data+1;
$next2 = $data+2;
$pagination .= "<li class='uk-active'><span>$data</span></li>
                <li><a href='producten.php?data=$next1'>$next1</a></li>
                <li><a href='producten.php?data=$next2'>$next2</a></li>
                <li><a href='producten.php?data=$next1'>></a></li>
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

<div class="uk-flex uk-flex-center">
<?php echo $pagination ?>
</div>

</main>
<?php
  include "includes/footer.php";
  ?>
  
</body>
</html>