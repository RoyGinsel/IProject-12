<?php
include "functies.php";

                    foreach(query("SELECT * FROM tblRubriek r WHERE NOT EXISTS (SELECT 1 FROM tblRubriek WHERE parentRubriek = r.rubrieknummer)") as $row){
                        echo "<option value=".$row['rubriekNummer'].">".$row['rubriekNaam']." Pr.".$row['parentRubriek']."</option>";
                    }
                ?>