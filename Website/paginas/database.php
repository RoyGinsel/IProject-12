<?php
  $hostname = "DESKTOP-BFMGFQ8";
  $dbname = "EenmaalAndermaal";
  $username = "user";
  $pw = "P@ssw0rd";

    try { //probeer connectie te maken
        $dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname;
			ConnectionPooling=0", "$username", "$pw");
        $dbh->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    } //geeft foutmelding
    catch (PDOException $e) {
        //$e->getMessage();
        //exit("Database connectie heeft gefaald, Het script is gestopt, hier een virtueel koekje 🍪.");
    }
?>
