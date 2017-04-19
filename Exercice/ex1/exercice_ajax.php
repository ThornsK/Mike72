<!DOCTYPE html>
<html>
	<head>
		<title>Exercice</title>
		<script src="
			https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
		</script>
	</head>
	<body>
		<div>
			<table border="1" id="tableau">
		</div>



		<script>
			$(function() {

			// requete AJAX : 


			var request = $.ajax({
				url: "http://jsonplaceholder.typicode.com/users",
				method: "GET",
				timeout: 3000,
			});



			request.done(function(msg) {
				console.log(msg);

				var table = "<tr>";
            $.each(msg[0], function(index, value) {
               table += "<th>";
               table += index;
               table += "</th>";
            });

            table += "</tr>";
            for (var i = 0; i < msg.length; i++) {
                table += "<tr>";                    

                $.each(msg[i], function(index, value) { // le foreach en Javascript
                        table += "<td>";
                    if(index == "address") {
                        table += value.street;
                        table += " ";
                        table += value.city;
                        table += " ";
                        table += value.zipcode;
                    }
                    else if(index == "company") {
                        table += value.name;    
                    }
                    else {
                        table += value;                    
                    }
                    table += "</td>";                     
                }); // fin de la boucle each

                table += "</tr>";
            }; // fin de la boucle for

            table += "</tr>"; // le += est l'équivalent de .= dans le php

            $( "#tableau" ).html( table );
            console.log(table);

        }); // fin du request.done



			request.fail(function( jqXHR, textStatus ) {

				alert( "Request failed : " + textStatus );

			}); // fin du request.fail



			}); // fin de document ready

			




			/*});*/

		</script>

		
			
		</table>
	</body>
</html>