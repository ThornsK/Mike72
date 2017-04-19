<?php

header("Access-Control-Allow-Origin: *");

$pdo = new PDO(
	"mysql:host=localhost;dbname=Mike", "root", "",
	array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
		
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"

));

$resultat = $pdo->prepare("SELECT * FROM utilisateurs");
$resultat->execute();
$utilisateurs = $resultat->fetchAll();




	$resultat = $pdo->query("SELECT * FROM utilisateurs");
	$resultat->execute();
	

	/*echo " nombre de résultats : " . $resultat -> rowCount() . "<br/>";*/

	echo "<h1>" . "C'est du AJAX" . "</h1>";

  	echo "<div>
  			<div>
  				<p>Requete : <span id='Requete'></span></p>
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

	/*$utilisateurs = $resultat->fetch(PDO::FETCH_ASSOC);*/


	/*echo json_encode($utilisateurs);*/ // convertir un array php en Json
?>