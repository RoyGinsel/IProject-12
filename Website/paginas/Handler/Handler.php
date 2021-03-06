<?php
session_start();
include "../functies.php";


// kijken of form wel gesubmit is.
if(!isset($_POST['submit'])){
  echo "Formulier is niet gesubmit";
}else{


  // kijken of wachtwoord wel is ingevuld,

  if (empty($_POST['Wachtwoord']) && empty($_POST['WachtwoordHer'])){

    header('Location: /iproject-12/website/paginas/register.php?error=Wachtwoord');
    die();

  }


  // kijken of password wel zelfde is
  if ($_POST['Wachtwoord'] != $_POST['WachtwoordHer'] ) {



  header('Location: /iproject-12/website/paginas/register.php?error=Wachtwoord');
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


  $registrationForm = ["userName" => $_POST['Gebruikersnaam'], "Voornaam" => $_POST['Voornaam'], "Achternaam" => $_POST['Achternaam'], "Adres" => $_POST['Adres'], "AdresExtra" => $_POST['AdresExtra'], "Postcode" => $_POST['Postcode'],"Plaatsnaam" =>
  $_POST['Plaatsnaam'], "Land" => $_POST['Land'], "Geboortedatum" => $_POST['Geboortedatum'],"Password" =>  $_POST['Wachtwoord'], "PasswordHer" =>  $_POST['WachtwoordHer'], "Geheimevraag" => $_POST['Geheimevraag'],"Antwoordvraag" => $_POST['Antwoordvraag']];


//sanitize invoervelden
  foreach($registrationForm as $key => $value){

    $registrationForm[$key] = filter_var($value, FILTER_SANITIZE_STRING);
  };


// zet de array om in variabelen zodat er gekeken kan worden of ze bestaan.
  extract($registrationForm, EXTR_PREFIX_SAME, "wddx");


//kijken of de gebruikersnaam al bestaat.
  if (!empty(checkavailableUsername($userName))) {




      header('Location: /iproject-12/website/paginas/register.php?error=Gebruikersnaam');
      die();
  }else


  // kijken of email bestaat
  if (!empty(checkavailableMail($email))) {


      header('Location: /iproject-12/website/paginas/register.php?error=Email');
      die();
    }else {

      $hashpassword = password_hash($Password, PASSWORD_DEFAULT);

      //wachtwoord verwijderen uit formulier voor veiligheidsredenen

      if(isset($hashpassword)){

        $registrationForm['Password'] = $hashpassword;
        $registrationForm['Mail'] = $email;
        unset($registrationForm['PasswordHer']);

        //inserten
        newAccount($registrationForm);
        $_SESSION['username'] = $userName;
        $_SESSION['date'] = date('d-m-Y');
        header('Location: /iproject-12/website/paginas/index.php');
            }

    };
  }


  echo '<pre>', var_dump($registrationForm), '</pre>';



?>
