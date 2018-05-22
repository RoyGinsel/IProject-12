<?php
session_start();
Require_once('../functies.php');


// kijken of form wel gesubmit is.
if(!isset($_POST['submit'])){
  echo "Formulier is niet gesubmit";
}else{


  // kijken of wachtwoord wel is ingevuld,

  if (empty($_POST['Wachtwoord']) && empty($_POST['WachtwoordHer'])){

    echo "wachtwoord is niet ingevuld";
    die();

  }


  // kijken of password wel zelfde is
  if ($_POST['Wachtwoord'] != $_POST['WachtwoordHer'] ) {



    echo "wachtwoord is niet het zelfde";
    Die();
  }




//sanitize Email
  if(isset($_POST['email'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
  }else{

    die();

  }


// sanitize Telefoonnummer

if(isset($_POST['Telefoonnummer'])){

  if(!filter_var($_POST['Telefoonnummer'],FILTER_VALIDATE_INT) === false){


    echo "is geen int";
    Die();

  }

}


// text velden in array stoppen.

  $registratieForm = ["Voornaam" => $_POST['Voornaam'], "Achternaam" => $_POST['Achternaam'], "Gebruikersnaam" => $_POST['Gebruikersnaam'], "Adres" => $_POST['Adres'], "Adres2" => $_POST['Adres2'], "Postcode" => $_POST['Postcode'],"Plaats" =>
  $_POST['Plaats'], "Land" => $_POST['Land'], "Wachtwoord" => $_POST['Wachtwoord'], "WachtwoordHer" =>  $_POST['WachtwoordHer'], "Geheimevraag" => $_POST['Geheimevraag']];


//sanitize strings
  foreach($registratieForm as $key => $value){

    $registratieForm[$key] = filter_var($value, FILTER_SANITIZE_STRING);
  };


// zet de array om in variabelen zodat ze geinsert kunnen worden.
  extract($registratieForm, EXTR_PREFIX_SAME, "wddx");


//kijken of de gebruikersnaam al bestaat.
  if (!empty(checkbestaandeGebruikersNaam($Gebruikersnaam))) {




      header('Location: /iproject-12/website/paginas/register.php?error=Gebruikersnaam');
      die();
  }


  // kijken of email bestaat
  if (!empty(checkbestaandemail($email))) {




      header('Location: /iproject-12/website/paginas/register.php?error=email');
      die();
    }else {

  $hashpassword = password_hash($Wachtwoord, PASSWORD_DEFAULT);

  // wachtwoord verwijderen uit formulier.

  if(isset($hashpassword)){
  unset($Wachtwoord,$WachtwoordHer);
  $Verwijderen = array('Wachtwoord','WachtwoordHer');

  foreach($Verwijderen as $key){

    unset($registratieForm[$key]);
  }

  };
}




echo $Voornaam;




}
?>
