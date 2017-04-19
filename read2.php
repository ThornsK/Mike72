<?php
header("Access-Control-Allow-Origin : *"); //les requetes http de type crosssite sont des requetes pour des ressources localisees sur un domaine different de celui a l'origine de la requete 


$retour = array("erreur" => true);

if(isset($_POST["requet"]) && isset($_POST["datab"])){

    if(!empty($_POST["requet"]) && !empty($_POST["datab"])){

        $bdd = $_POST["datab"];

        $pdo = new PDO("mysql:host=localhost;dbname=$bdd", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


        $resultat = $pdo -> prepare($_POST["requet"]);        
        

        if (!$resultat) {
            $retour["message"] = $pdo->errorInfo()["2"];
            echo json_encode($retour);
            return;
        }
        $resultat -> execute();   

        $utilisateurs = $resultat -> fetchAll(PDO::FETCH_ASSOC);
        
        $tableau = "<div><div><p>Requet : <span id='requet'></span></p><p>Nombre de lignées : <span id='lignees'>".$resultat->RowCount()."</span></p></div><div><table border='1'><tr>";  

        foreach ($utilisateurs[0] as $key => $value) {
            $tableau .= "<th>" . $key ."</th>";

        }        

        $tableau .= "</tr>"; 

        for ($i=0; $i < count($utilisateurs); $i++) {
            
        $tableau .= "<tr>";

            foreach ($utilisateurs[$i] as $key => $value) {
                $tableau .= "<td>" . $value . "</td>";
            }
            $tableau .= "</tr>";

        }        

        $tableau .= "</table></div></div><br>";

        $retour["erreur"] = false;
        $retour["message"] = $tableau;    
    } // fin du empty  
        else {
        $retour["message"] = "Parametre vide!"; // gestion erreur if emmpty
    }
} // fin du isset 
else {
    $retour["message"] = "Parametre manquant"; // gestion erreur if !isset
}
echo json_encode($retour);







/* ancient
$pdo = new PDO("mysql:host=localhost", "root", "");
$databases = $pdo -> query("SHOW DATABASES");
$databases = $databases -> fetchAll(PDO::FETCH_ASSOC);if ($_GET && !$_POST) {    if (isset($_GET["repetition"])) {
        $repetition = explode(" - ", $_GET["repetition"]);
        $bdd = $repetition[0];
        $requete = $repetition[1];        $pdo = new PDO("mysql:host=localhost;dbname=$bdd", "root", "");
        $resultat = $pdo -> prepare("$requete");        if($resultat -> execute()){            $display = $resultat -> fetchAll(PDO::FETCH_ASSOC);            $tables = $pdo -> query("SHOW TABLES");
            $tables = $tables -> fetchAll(PDO::FETCH_ASSOC);            // traitement fichier historique
            $historique = fopen("historique.txt", "a");
            fwrite($historique, $bdd . " - " . $requete . "\r\n");
            fclose($historique);            $msg = "<p style='padding: 10px; background-color: green;'>Voici le resultat de votre requete</p>";
            if(empty($display)){
                $msg = "<p style='padding: 10px; background-color: green;'>Votre requete a été effectuée avec succès</p>";
            }
        }
    }    if (isset($_GET["deletion"]) && !$_POST && file_exists("historique.txt")) {
        unlink("historique.txt");
        header("location:?");
    }
}if($_POST){$bdd = $_POST["database"];
$pdo = new PDO("mysql:host=localhost;dbname=$bdd", "root", "");$requete = $_POST["sql"];
$resultat = $pdo -> prepare("$requete");    if($resultat -> execute()){        $display = $resultat -> fetchAll(PDO::FETCH_ASSOC);        $tables = $pdo -> query("SHOW TABLES");
        $tables = $tables -> fetchAll(PDO::FETCH_ASSOC);        $historique = fopen("historique.txt", "a");
        fwrite($historique, $bdd . " - " . $requete . "\r\n");
        fclose($historique);        $msg = "<p style='padding: 10px; background-color: green;'>Voici le resultat de votre requete</p>";        if(empty($display)){
            $msg = "<p style='padding: 10px; background-color: green;'>Votre requete a été effectuée avec succès</p>";
        }
    }    else {
        $erreur = $resultat ->errorInfo();
        $msg = "<p style='padding: 10px; background-color: red;'>" . $erreur[2] . "</p>";
        }}
*/ 
?>