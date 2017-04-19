<?php
// ne rien mettre au dessus de header
header("Access-Control-Allow-Origin: *");

if(isset($_POST["requete"]) && isset($_POST["data"])) {
// il faut y mettre la valeur de data, donc "requete".
	if (!empty($_POST["requete"]) && !empty($_POST["data"])) {
		

// connexion BDD

	$pdo = new PDO(
		'mysql:host=localhost;dbname='. $_POST["data"], "root", "",
		array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"

	));

	$resultat = $pdo->prepare($_POST["requete"]);
	$resultat->execute();
	$utilisateurs = $resultat->fetchAll();




		$resultat = $pdo->query($_POST["requete"]);
		$resultat->execute();
		

		/*echo " nombre de résultats : " . $resultat -> rowCount() . "<br/>";*/

		echo "<h1>" . "C'est du AJAX" . "</h1>";

	  	echo "<div>
  			<div>
  				<p>Requete : <span id='requete'></span></p>
  				<p>Nombre de lignes : <span id='lignes'>".$resultat->rowCount()."</span></p>
			</div>
		  <div>
		<table border='1'>";
			echo "<tr>";

		for($i = 0; $i < $resultat -> columnCount(); $i++){
			$meta = $resultat -> getColumnMeta($i);
			echo "<th>" . $meta['name'] . "</th>";
		
		}

			echo "</tr>"; 

		while ($tableau = $resultat->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			foreach ($tableau as $key => $value) {
				echo "<td>" . $value . "</td>";
			
			}
			echo "</tr>";
		}

		echo "</table></div></div>";









	} // fin du empty $_POST
} // fin du isset $_POST

	/*$utilisateurs = $resultat->fetch(PDO::FETCH_ASSOC);*/


	/*echo json_encode($utilisateurs);*/ // convertir un array php en Json
?>