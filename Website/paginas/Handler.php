<?php
session_start();

include("functies.php");

// kijken of form wel gesubmit is.
if(!isset($_POST['submit'])){
  echo "Formulier is niet gesubmit";
}else{
  // kijken of wachtwoord wel is ingevuld,
  if (empty($_POST['Wachtwoord']) && empty($_POST['WachtwoordHer'])){
    header('location: ./Register.php?error=Wachtwoord');
  }
  // kijken of password wel zelfde is
  if ($_POST['Wachtwoord'] != $_POST['WachtwoordHer'] ) {
    header('location: ./Register.php?error=Wachtwoord');
    die();
  }
//sanitize Email
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
// sanitize Telefoonnummer
  if(!filter_var($_POST['Telefoonnummer'],FILTER_VALIDATE_INT) == false){
    echo "is geen int";
    Die();
  }

  $registrationForm = ["userName" => $_POST['Gebruikersnaam'], "voornaam" => $_POST['Voornaam'], "achternaam" => $_POST['Achternaam'], "adres" => $_POST['Adres'], "adresExtra" => $_POST['AdresExtra'], "postcode" => $_POST['Postcode'],"plaatsnaam" =>
  $_POST['Plaatsnaam'], "land" => $_POST['Land'], "geboortedatum" => $_POST['Geboortedatum'],"password" =>  $_POST['Wachtwoord'], "passwordHer" =>  $_POST['WachtwoordHer'], "geheimevraag" => $_POST['Geheimevraag'],"antwoordvraag" => $_POST['Antwoordvraag']];

//sanitize invoervelden
  foreach($registrationForm as $key => $value){
    $registrationForm[$key] = filter_var($value, FILTER_SANITIZE_STRING);
  };

// zet de array om in variabelen zodat er gekeken kan worden of ze bestaan.
  extract($registrationForm, EXTR_PREFIX_SAME, "wddx");
  

//kijken of de gebruikersnaam al bestaat.
if(!empty(checkavailableMail($email))) {


  echo "mail";
  header('location: ./Register.php?error=Email');
  die();


}

  // kijken of email bestaat

  if(!empty(checkavailableUsername($userName))) {

    echo "username";
    header('location: ./Register.php?error=Gebruikersnaam');
    die();


  }else {

     $hashpassword = password_hash($password, PASSWORD_DEFAULT);
      //wachtwoord verwijderen uit formulier voor veiligheidsredenen
      
        $registrationForm['password'] = $hashpassword;
        $registrationForm['mail'] = $email;
        

        
        newAccount($registrationForm);
    
        $_SESSION['username'] = $userName;
        $_SESSION['date'] = date('d-m-Y');
      
            }

     }
    
?>
