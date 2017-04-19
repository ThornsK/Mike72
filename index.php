<?php

$pdo = new PDO(
		"mysql:host=localhost;dbname=Mike", "root", "",
		array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
			
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"

	));

$resultat = $pdo->prepare("SHOW DATABASES");
$resultat->execute();

$database = $resultat->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>AJAX</title>
		<script src="
		https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
		</script>
	</head>
	<body>


		<h1>Lanceur de requêtes</h1>
		<form method="post" action="">
			<label>Selection base de donnée : </label><br/>
			<select id="select_bdd">
					<?php
						foreach($database as $key => $value) {
							echo "<option value='".$value['Database']."'>".$value['Database']."</option>";
						}
					?>
			</select><br/>
			<textarea id="requete" name="requete" rows="4" cols="50" placeholder="Veuillez saisir votre requête">
				
			</textarea></form><br/>
			<input type="submit" value="Envoyer la requête">
		</form>

		<div id="mike">
		</div>
		<div>
			<p id="message">
					
			</p>	
		</div>

		<script>
			/**/
			$(function(){

				$("input").click(function(e){

					// annuler, l'actualisation de la page
					e.preventDefault();


					console.log("Mike");

					// récupération de la valeur de notre textarea
					var myRequest = $("#requete").val();

					var dataBase = $("#select_bdd").val();

					// Requête AJAX
					/*var menuId = $( "ul.nav" ).first().attr( "id" );*/
					var request = $.ajax({
						url: "read2.php", // page de la requête
						method: "POST", // methode de la requete
						data: {requet : myRequest, datab: dataBase} // Data envoyée à la page
					});

					request.done(function( msg ) { // success !
						console.log(msg);
						msg = JSON.parse(msg);


						if(msg.erreur == false) {

							$( "#mike" ).html( msg.message );
							$("#requete").html(myRequest);

							$("#message").text("Voici le résultat de votre requête : ");
							$("#message").css("background-color", "green");
							$("#message").css("color", "white");

						}
						else {
							$("#message").text(msg.message);
							$("#message").css("background-color", "red");
							$("#message").css("color", "white");

						}
					});

					request.fail(function( jqXHR, textStatus ) {
						alert( "Request failed: " + textStatus );
					});
				});
			});
		</script>
	</body>
</html>