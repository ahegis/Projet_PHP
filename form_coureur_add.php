<html>
	<head>
		<title>Formulaire d'Ajout d'un Coureur</title>
		<meta charset="UTF-8"/>
	</head>

	<body>
		<?php
		include("fonc_oracle.php");
		$login = "copie_tdf";
      	$mdp = 'copie_tdf';
      	$instance = 'xe';
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesPays($cur,$tab);
		?>
		    <script>
		    	function premierTDF(){
		    		val=(document.forms["general"].dateNaiss.min+18);
		    		return val;
		    	}
		    </script>
	    <?php	
		echo '"';echo (date('Y')-100);echo"-";echo (date('m-d'));echo '"';?> max=<?php echo '"';echo (date('Y')-18);echo"-";echo (date('m-d'));echo '"';?>
		<form action="add_coureur.php" method="POST">
			<table>
				<tr><td><label for="nom">Nom : </label></td>
					<td><input type="text" id="nom" name="nom" required="required"/></td></tr>
				<tr><td><label for="prenom">Prénom : </label></td>
					<td><input type="text" id="prenom" name="prenom" required="required"/></td></tr>
				<tr><td><label for"dateNaiss">Date de Naissance : </label></td>
					<td><input type="date" id="dateNaiss" name="DateNaiss" min=<?php echo '"';echo (date('Y')-100);echo"-";echo (date('m-d'));echo '"';?> max=<?php echo '"';echo (date('Y')-18);echo"-";echo (date('m-d'));echo '"';?> onclick="premierTDF()"/></td></tr>
				<tr><td><label for="pays">Pays : </label></td>
					<td><select name="pays" size="1">
						<?php
							for($i=0;$i<$nbLignes;$i++){
								echo '<option value="'.$tab[$i][0].'">'.$tab[$i][1];
								echo '</option>';
							}
						?>
					</select></td></tr>
				<tr><td><label for="dateTDF">Année TDF : </label></td>
					<td><input type="date" id="dateTDF" name="dateTDF" min="" max="" onclick='premierTDF()'/></td></tr>	
				<tr><td><input type="submit" id="valider" value="Ajouter"/>


			</table>


		</form>









	</body>


</html>