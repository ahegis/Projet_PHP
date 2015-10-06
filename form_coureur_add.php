<?php
	include("header.html");
?>
	<title>Formulaire Ajout Coureur</title>
	<h1 style='font-variant:small-caps;text-align:center'>Consultation des Coureurs de la Base</h1>
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
		$valid=true;
		if(isset($_POST['nom'])){

			if(isset($_POST['nom']))
				if(verif_caractere($_POST['nom']))
					$nom=valid_nom($_POST['nom']);
				else $valid=false;
			else $valid=false;

			if(isset($_POST['prenom']))
				if(verif_caractere($_POST['prenom']))
					$prenom=valid_prenom($_POST['prenom']);
				else $valid=false;
			else $valid=false;

			if(isset($_POST['anneeNaiss']))
				$anneeNaiss=$_POST['anneeNaiss'];
			else $valid=false;

			if(isset($_POST['pays'])){
				$pays_valid=false;
				for($i=0;$i<$nbLignes;$i++){
					if($_POST['pays']==$tab[$i][0])$pays_valid=true;
				}
				if($pays_valid)$pays=$_POST['pays'];
			}
			else $valid=false;

			if(isset($_POST['anneeTDF']))
				if($_POST['anneeTDF']-$anneeNaiss>=0)
					$anneeTDF=$_POST['anneeTDF'];
				else $valid=false;
			else $valid=false;

			if($valid){
				$req_numero='SELECT max(N_COUREUR) as num_max from tdf_coureur';
				$cur = PreparerRequete($conn,$req_numero);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
		    	$nbLignes = LireDonnees1($cur,$tab);
		    	$n_coureur=$tab['NUM_MAX'][0]+1;
		    	
				$req_inser = 'INSERT INTO tdf_coureur (N_COUREUR,NOM,PRENOM,ANNEE_NAISSANCE,CODE_TDF,ANNEE_TDF) values ('.$n_coureur.',\''.$nom.'\',\''.$prenom.'\','.$anneeNaiss.',\''.$pays.'\','.$anneeTDF.')';
	      		
	      		//echo $req_inser;
	      		if(!exist_coureur_inser($nom,$prenom,$pays)){
	      			echo "insertion efectuée";
	      			/*$cur = PreparerRequete($conn,$req_inser);
		    		$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
					$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
		    		$res = ExecuterRequete($cur);*/
		    	}
		    	else ?><script>window.alert("Coureur déjà présent dans la base");</script><?php
			}
			else echo "Champ(s) Invalide(s) (non rempli ou incorrect)";
		}
		
		include("footer.html");