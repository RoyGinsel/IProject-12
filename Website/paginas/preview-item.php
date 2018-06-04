<div class="call-out uk-width-5-6 uk-position-center uk-padding-remove uk-margin-remove " uk-alert>
    <a class="sluiten uk-alert-close" uk-close ></a>
    <?php
     session_start();
     include "functies.php";
    $date = date_create(date("Y/m/d"));
     date_add($date, date_interval_create_from_date_string($_POST['form_ids'][5].'days'));
    ?>
<main class="uk-visible@s uk-grid detailpaginaLayout uk-flex-center uk-margin-remove">
      <div class="uk-card uk-card-default uk-width-1-3">
        <div class="uk-card-media-top uk-margin-top" uk-slideshow>
        <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Upload foto's</h1>
        <input id="browse" type="file" name="fotos" onchange="previewFiles()" multiple>
          <ul id="preview" class="uk-slideshow-items uk-slid uk-margin-right voorwerpFoto">
          </ul>
          <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
          <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
        </div>


          <!-- omschrijving -->
          <?php
        $omschrijving = '
        <div class="uk-width-1-1">
          <h1 class="uk-card-title uk-text-center uk-margin-top">Omschrijving</h1>
          <ul class="voorwerpOmschrijving uk-margin-remove uk-padding-remove">
            <li class="uk-margin-top">Titel: '.$_POST['form_ids'][0]. '</li>
            <li class="uk-margin-top">Omschrijving: '.$_POST['form_ids'][9]. '</li>
            <li class="uk-margin-top">Looptijd: '.$_POST['form_ids'][5]. ' dagen</li>
            <li class="uk-margin-top">Gestart op: '.date("Y/m/d").' </li>
            <li class="uk-margin-top">Eindigd op: '.date_format($date, 'Y-m-d').'</li>
          </ul>
        </div>
      </div>
      ';
      echo $omschrijving;
      ?>
       <!-- samenvatting -->
       <?php
      $voorwerpNummer = newVoorwerpNummer();
       $samenvatting = '
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-left">
        <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Samenvatting:</h1>
        <table method="post" class="uk-table uk-table-divider uk-width-1-1 ">
          <tr>
            <td>Voorwerpnummer:</td>
            <td>'.$voorwerpNummer[0]['voorwerpnummer'].'</td>
          </tr>
          <tr>
            <td>Locatie:</td>
            <td>'.$_POST['form_ids'][1].', '.$_POST['form_ids'][2].'</td>
          </tr>
          <tr>
            <td>Betalingswijze:</td>
            <td>'.$_POST['form_ids'][6].'</td>
          </tr>
          <tr>
            <td>Betalingsinstructie:</td>
            <td>'.$_POST['form_ids'][8].'</td>
          </tr>
          <tr>
            <td>Startprijs:</td>
            <td>&euro; '.$_POST['form_ids'][3].'</td>
          </tr>
          <tr>
            <td>Verzendkosten:</td>
            <td>&euro; '.$_POST['form_ids'][4].'</td>
          </tr>
          </table>
          <table method="post" class="uk-table uk-table-divider uk-width-1-1 ">
          <h1 class="uk-card-title uk-margin-remove uk-text-center uk-width-1-1">Info over verkoper:</h1>
          <tr>
            <td>Naam:</td>
            <td>'.$_SESSION['username'].'</td>
          </tr>
        </table>
      </div>
     ';

     echo $samenvatting;
      ?>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-3 uk-margin-top">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Bieden:</h1>
          <form action="" method="post" class="uk-panel uk-panel-box uk-form">
            <div class="uk-form-row">
              <input class="uk-width-1-3 uk-form-large" name="invoerBod" type="number"  placeholder="Bod" >
              <input class="uk-button uk-button-primary uk-width-1-2 uk-padding-remove" type="Submit" name="Bod" value="Bieden">
            </div>
          </form>
        </div>
        <div class="uk-body">
            <table class="uk-table uk-table-middle uk-table-divider ">
              <tr>
                <th>Gebruiker:</th>
                <th>Bod:</th>
                <th>Datum en Tijd:</th>
              </tr>
            </table>
        </div>
      </div>
      <div class="uk-card uk-card-default uk-card-body uk-width-1-2 uk-margin-top uk-margin-left">
        <div class="uk-card-header">
          <h1 class="uk-card-title uk-padding-remove uk-text-center">Reacties op verkoper:</h1>
        </div>
        <div class="uk-body uk-scrollable-text">
            <table class="uk-table uk-table-middle uk-table-divider ">
              <tr>
                <th>Commentaar:</th>
                <th>Van:</th>
                <th>Datum en Tijd:</th>
                <th>Voorwerp:</th>
              </tr>
            </table>
        </div>
      </div>
    </main>
      <button type="submit" class="uk-button uk-width-1-1 uk-button-default uk-button-primary uk-margin-medium-top" name="submit">Publiceer</button>

      </div>