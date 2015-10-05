<html>
	<head>
		<title>Selection de Tables en Insertion</title>
		<meta charset="UTF-8"/>
	</head>

	<body>
		<header style="text-align:center;font-size:40;color:darkblue">Mise à Jour de la Base TDF</header>

		<div> 	<table><tr>
					<td><a href="index.php">Accueil</a></td>
					<td style="border-right=0.5"><a href="select_consult.php" style="font-color:black">Consultation Tables</a></td>
					<td><a href="select_insert.php">Insertion dans une Table</a></td>
				</tr></table>

		</div>



		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<select id="table" name="table">
				<option value"none">Non Selectionné</option>
				<option value="TDF_COUREUR">TDF_COUREUR</option>
			</select>
			</br></br>
			<input type="submit" name="valider" value="valider"/>

		</form>



		<?php
			if(isset($_POST['table'])){
				$table=$_POST['table'];
				switch($table){
					case "TDF_COUREUR":	echo "abcde";
										header("location:form_coureur_add.php");
										break;
				}
			}


		?>



	<body>

</html>