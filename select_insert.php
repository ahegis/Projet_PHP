<?php
	include("header.html");
?>

	<title>Sélection de Table pour Insertion</title>

	<h1 style='font-variant:small-caps;text-align:center'>Choix de la Table à Editer</h1>"
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style="text-align:center">
			<select id="table" name="table">
				<option value"none">Non Selectionné</option>
				<option value="TDF_COUREUR">TDF_COUREUR</option>
				<option value="TDF_ANNEE">TDF_ANNEE</option>
			</select>
			</br></br>
			<input type="submit" name="valider" value="valider"/>

		</form>



		<?php
			if(isset($_POST['table'])){
				$table=$_POST['table'];
				switch($table){
					case "TDF_COUREUR":	header("location:form_coureur_add.php");
										break;
					case "TDF_ANNEE" : 	header("location:form_annee_add.php");
										break;
				}
			}

		include("footer.html");