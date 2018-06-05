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
            $e->getMessage();
        }
    }

    function section($number)
    {
        return preparedQuery("select * from tblRubriek where rubriekNummer = :number",['number' => $number]);
    }

    function allSections()
    {
        return Query("SELECT c.rubriekNaam, c.rubriekNummer, p.rubriekNaam as parentNaam
                    from tblRubriek c inner join tblRubriek p on c.parentRubriek=p.rubriekNummer
                    order by rubriekNaam asc");
    }

    function renameSection($name, $number)
    {
        preparedQuery("UPDATE tblRubriek
                        SET rubriekNaam = :name
                        where rubriekNummer = :number",['name' => $name,'number' => $number]);
    }

    function checkSubSections($number)
    {
        if(preparedQuery("SELECT * from tblRubriek where parentRubriek = :number",['number' => $number]) == false){
            var_dump(preparedQuery("SELECT * from tblRubriek where parentRubriek = :number",['number' => $number]));
            return 0;
        } else  {
            return 1;
        }
    }

    function changeParentRubriek($number, $newParent)
    {
        preparedQuery("update tblRubriek
                        set parentRubriek = :newParent
                        where parentRubriek = :number",['newParent'=> $newParent, 'number' => $number]);
    }

    function checkAuctions($number)
    {
        if(preparedQuery("SELECT * from tblVoorwerpRubriek where rubriekNummer  = :number",['number' => $number]) == false){
            return 0;
        } else {
            return 1;
        }
    }

    function deleteRubriek($number)
    {
        preparedQuery("DELETE from tblRubriek
                        where rubriekNummer = :number",['number' => $number]);
    }

    function deleteAuctionRubriek($number)
    {
        preparedQuery("DELETE from tblVoorwerpRubriek
                        where rubriekNummer = :number",['number' => $number]);
    }


    //geeft alle users weer 
    function getUsers(){


        return Query("Select gebruikersNaam, geblokkeerd from tblGebruiker where geblokkeerd = 0");
    
    }


    function blockUser($user){


     preparedQuery("UPDATE tblGebruiker SET geblokkeerd = 1 where gebruikersnaam = :gebruiker",['gebruiker' => $user]);

    }
?>