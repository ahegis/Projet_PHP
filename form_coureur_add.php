<?php
	include("header.html");
?>
	<title>Formulaire Ajout Coureur</title>
	<h1 style='font-variant:small-caps;text-align:center'>Ajout d'un Coureur dans la Base</h1>
		<script>
		   	function premierTDF(){
		   		val=parseInt(document.getElementById("anneeNaiss").value)+parseInt(18);
	    		document.getElementById("anneeTDF").min=val;
	    	}
		</script>

		<?php
		include("fonc_oracle.php");
		include("fonc_text.php");
		include("fonc_sql.php");
		include("log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesPays($cur,$tab);
		?>

		<form name="form_add" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >
			<table style="margin:auto">
				<tr><td><label for="nom">Nom : </label></td>
					<td><input type="text" id="nom" name="nom" required="required" style="width:100%"/></td></tr>
				<tr><td><label for="prenom">Prénom : </label></td>
					<td><input type="text" id="prenom" name="prenom" required="required" style="width:100%"/></td></tr>
				<tr><td><label for"dateNaiss">Année de Naissance : </label></td>
					<td><input type="number" id="anneeNaiss" name="anneeNaiss" min=<?php echo '"';echo (date('Y')-100);echo '"';?> max=<?php echo '"';echo (date('Y')-18);echo '"';?> onclick="premierTDF()" style="width:100%"/></td></tr>
				<tr><td><label for="pays">Pays : </label></td>
					<td><select name="pays" size="1">
							<option value="nul" disabled checked>Séléctionnez un Pays</option>
						<?php
							for($i=0;$i<$nbLignes;$i++){
								echo '<option value="'.$tab[$i][0].'">'.$tab[$i][1];
								echo '</option>';
							}
						?>
					</select></td></tr>
				<tr><td><label for="dateTDF">Année TDF : </label></td>
					<td><input type="number" id="anneeTDF" name="anneeTDF" min="" max="" style="width:100%"/></td></tr>	
				<tr><td></br></td></tr>
				<tr style="text-align:center"><td><input type="reset" id="annuler" value="Annuler"/></td>
							<td><input type="submit" id="valider" value="Ajouter"/></td></tr>


			</table>

		</form>

		<?php
		if(isset($_POST['nom'])){

			$tab_verif=verif_inser_coureur($_POST['nom'],$_POST['prenom'],$_POST['anneeNaiss'],$_POST['pays'],$_POST['anneeTDF']);

			if($tab_verif[0]){
				$req_numero='SELECT max(N_COUREUR) as num_max from tdf_coureur';
				$cur = PreparerRequete($conn,$req_numero);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
		    	$nbLignes = LireDonnees1($cur,$tab);
		    	$n_coureur=$tab['NUM_MAX'][0]+5;
				$req_inser = 'INSERT INTO tdf_coureur (N_COUREUR,NOM,PRENOM,ANNEE_NAISSANCE,CODE_TDF,ANNEE_TDF) 
				values ('.$n_coureur.',\''.$tab_verif[1].'\',\''.$tab_verif[2].'\','.$tab_verif[3].',\''.$tab_verif[4].'\','.$tab_verif[5].')';
	      		
	      		if(!exist_coureur_inser($tab_verif[1],$tab_verif[2],$tab_verif[4])){
	      			$cur = PreparerRequete($conn,$req_inser);
		    		$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
					$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
		    		$res = ExecuterRequete($cur);
		    		?><script>window.alert("Coureur inséré dans la base");</script><?php
		    		header("location:form_coureur_look.php");
		    	}
		    	else {?><script>window.alert("Coureur déjà présent dans la base");</script><?php echo "";}
			}
			else {?><script>window.alert("Champ(s) Invalide(s) ( Incomplet(s) ou Vide(s) )");</script><?php echo "";}
		}
		include("footer.html");