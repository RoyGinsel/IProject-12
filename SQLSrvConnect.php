<?php
try
{
    $dbh = new PDO("sqlsrv:Server=mssql2.iproject.icasites.nl,1433;Database=iproject12;ConnectionPooling=0", "iproject12", "zGP7JWvP2U");
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e)
{
    echo $e->getMessage();
    exit(";klasdjfioasdjfkawe;ljfioskdljfiowejf");
}
?>
