<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
$url =  $_SERVER['REQUEST_URI'];
 $url = basename($url);;
  $breadcrumb = "<li><a href='index.php'>Home</a></li>";
  foreach($crumbs as $crumb) {
    $breadcrumb .= "<li><a href='$crumb.php'>$crumb</a></li>";
  }

  //Cookie zetten voor callout
  $cookie_name = "Callout";
  $cookie_value = date("Y-m-d");
  setcookie($cookie_name ,$cookie_value,time() + (86400 * 30),"/",null,null,null);
?>

<header>
  <div class="uk-flex-inline uk-flex-between uk-flex-middle uk-width-1-1 header">
    <div class="uk-flex uk-flex-row">
      <button type="button" class="uk-button uk-button-small uk-padding-remove uk-margin-small-left"><img src="../media/Hamburgermenu.png" alt=""></button>
      <div class="dropmenu" uk-dropdown>
        <ul class="uk-nav uk-dropdown-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="producten.php">Producten</a></li>
          <!-- If user is ingelogd show uitloggen anders show inloggen + rest -->
          <?php if(isset($_SESSION['username'])){
            echo '<li><a href="#">Mijn biedingen</a></li>';
            if(getSellerInfo($_SESSION['username']) && !getPossibleBuyer($_SESSION['username'])){
              echo '<li><a class="uk-text-success uk-text-center uk-text-uppercase " href="upgrade.php">Verkoopaccount activeren</a></li>';
            }
            if(getSellerInfo($_SESSION['username']) && getPossibleBuyer($_SESSION['username'])){
              echo '<li><a href="Mijn-veilingen.php">Mijn veilingen</a></li>';
            }
            echo '<li><a class="uk-text-danger uk-text-center uk-text-uppercase " href="uitloggen.php">Uitloggen</a></li>';
          }else{
            echo '<li><a href="inloggen.php">Inloggen</a></li>';
            echo '<li><a href="Register.php">Registreren</a></li>';
          }
          ?>
        </ul>
      </div>
      <!-- Rubrieken dropdown medium & larger -->
      <div class="uk-flex uk-flex-row">
        <button type="button" class=" rubrieken uk-button uk-button-small uk-margin-small-left uk-text-capitalize">Rubrieken</button>
        <div class="uk-width-1-3@s uk-width-3-4 uk-padding-remove-left uk-padding-remove-right uk-margin-remove-left uk-margin-remove-right uk-child-width-1-3@M" uk-dropdown="mode: click" uk-grid>
          <?php
            $id = "search1";
            if($url != 'producten.php'){
            include "Rubriekenboom-header-dropdown.php";
            }
          ?>
        </div>
      </div>
    </div>
    <div class="uk-visible@m">
    <h1 class=" uk-align-right uk-margin-medium-top uk-margin-small-right "><a href="index.php"> Eenmaal Andermaal</a></h1>
    </div>
    <div class=" mobileTitle uk-hidden@m  ">
    <h1 class=" mobileTitle uk-align-right uk-margin-medium-top uk-margin-small-right "><a href="index.php"> Eenmaal Andermaal</a></h1>
    </div>
  </div>

  <div class="uk-flex uk-flex-center  uk-width-1-1 breadcrumb uk-flex-inline uk-flex-center">
    <ul class="uk-breadcrumb crumb">
      <?php echo $breadcrumb; ?>
    </ul>
  </div>

 <?php
  if(isset($_SESSION['username'])){

   echo ' <div class="uk-flex uk-flex-left uk-width-1-1 userStat uk-flex-inline uk-flex-left">' ;

    $currentDate = date('d-m-Y');
      if(isset($_SESSION['username'])){
        echo "Welkom, ". $_SESSION['username']."! <br>";
        echo "Ingelogd op: ". $_SESSION['date']." <br>";
      //  echo '<a href="#">Upgrade naar verkoper!</a>';
      }
      if (isset($_GET["msg"]) && $_GET["msg"] == 'uitgelogd') {
        echo  '
        <div class="call-out uk-width-1-2 uk-text-center uk-position-center  uk-padding-large" uk-alert>
        <a class="sluiten uk-alert-close" uk-close ></a>
        <h2 class ="uk-text-small@s uk-text-large@m uk-margin-remove"> U bent uitgelogd!</h1>
        <p> Tot de volgende keer! </p> </div>';
      }

}
  ?>
  </div>
</header>
