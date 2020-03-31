<?php

include('db.php');


function liste_programme_aa($bdd, $niveau, $annee)
{
    $query = "SELECT * FROM programme_aa WHERE id_faculte = 'G' and niveau = '$niveau' and AA = '$annee' ";
    $req   = $bdd->query($query);
    
    if ($req->rowCount()) {
        
        echo "
        <div class='table-responsive'>
            <table class='table table-striped table-sm'>";
        
        while ($tuple = $req->fetch()) {
            
            echo "<tr><td>" . $tuple['programme_en'] . "</td></tr>";
            
        }
        
        echo "
            </table>
        </div>";
        
    }
    
}


function tous_programmes_aa($bdd)
{
    $query = "SELECT * FROM programme_aa WHERE id_faculte = 'G' and niveau IN ('master','doctorate','bac') ";
    $req   = $bdd->query($query);
    
    if ($req->rowCount()) {
        
        echo "
        <div class='table-responsive'>
            <table class='table table-striped table-sm'>";
        
        echo "
        <thead>
            <tr>
                <th>Code du programme</th>
                <th>Nom du programme</th>
                <th>Niveau</th>
            </tr>
        </thead>";
        
        echo "<tbody>";
        
        while ($tuple = $req->fetch()) {
            
            echo "<tr><td>" . $tuple['code_programme'] . "</td>";
            echo "<td>" . $tuple['programme_en'] . "</td>";
            echo "<td>" . $tuple['niveau'] . "</td></tr>";
            
        }
        
        echo "
                </tbody>
            </table>
        </div>";
        
    }
    
}

?>