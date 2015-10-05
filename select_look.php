<?php
	include("header.html");
?>

	<title>Sélection de Table pour Consultation</title>

	<h1 style='font-variant:small-caps;text-align:center'>Choix de la Table à Consulter</h1>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style="text-align:center">
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
					case "TDF_COUREUR":	header("location:form_coureur_look.php");
										break;
				}
			}

		include("footer.html");