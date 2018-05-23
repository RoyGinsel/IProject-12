<?php
    include "../Website/paginas/database.php";
    //include "../SQLSrvConnect.php";

    function query($stringquery)
    {
        try{
            global $dbh;
            $sql = $stringquery;
            $query = $dbh->prepare($sql);
            $query->execute();
            return $resultaat = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    function preparedQuery($stringquery,$parameters)
    {
        try{
            global $dbh;
    
            $query = $dbh->prepare($stringquery);
            $query->execute($parameters);
            return $query->fetchAll();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    function allSections()
    {
        echo "ik ben misbruikt";
        return Query("SELECT c.rubriekNaam, c.rubriekNummer, p.rubriekNaam as parentNaam
                    from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
                    order by rubriekNaam asc");
    }

    function test(){
        echo 'hallo';
    }
?>