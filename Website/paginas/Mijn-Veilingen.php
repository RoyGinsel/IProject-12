<?php
    session_start();
    include "functies.php";
    $crumbs = array();
// InlogCheck
 if(isset($_POST['post_gebruikersnaam']) && isset($_POST['post_wachtwoord'])){

   $username = $_POST['post_gebruikersnaam'];
   $password = $_POST['post_wachtwoord'];
   $hash = getPassword($username);

  if(loginCheck($username) == false){
       header('location: inloggen.php?msg=failed');
  }
 foreach(loginCheck($username) as $row){
   if(password_verify($password, $row['wachtwoord'])){
     $_SESSION['username'] = $username;
     $_SESSION['date'] = date('d-m-Y');
   }else
    header('Location: inloggen.php?msg=failed');
   }
 }
?>

<html lang="nl" dir="ltr">
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
    <main class="page">




    </main>
    <?php
        include "includes/footer.php";
    ?>
</body>
</html>