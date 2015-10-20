<?php
	include("header.html");
?>
	<title>Formulaire Ajout Epreuve</title>
	<h1 style='font-variant:small-caps;text-align:center'>Ajout d'une Epreuve dans la Base</h1>
		
		<?php
		include("fonc_oracle.php");
		include("fonc_text.php");
		include("fonc_sql.php");
		include("log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req_annee = 'SELECT annee,jour_repos FROM tdf_annee order by annee';
      	$cur = PreparerRequete($conn,$req_annee);
	    $res = ExecuterRequete($cur);
	    $nbLignes_annee = LireDonneesAnnee($cur,$tab_annee);
	    $req_pays = 'SELECT * FROM tdf_pays order by nom';
	    $cur = PreparerRequete($conn,$req_pays);
	    $res = ExecuterRequete($cur);
	    $nbLignes_pays = LireDonneesPays($cur,$tab_pays);
	    $req_type = 'SELECT * FROM tdf_categorie_epreuve';
	    $cur = PreparerRequete($conn,$req_type);
	    $res = ExecuterRequete($cur);
	    $nbLignes_type = LireDonnees2($cur,$tab_type);
		?>

		<form name="form_add" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >
			<table style="margin:auto">
				<tr><td><label for="nom">Annee : </label></td>
					<td><select name="annee" size="1" >
						<?php
							foreach($tab_annee as $i){
								echo '<option value="'.$i[0].'">'.$i[0];
								echo '</option>';
							}
						?>
					</select></td>
					<td><label for="n_epreuve">N° Epreuve : </label></td>
					<td><input type="number" id="n_epreuve" name="n_epreuve" required="required" style="width:100%" min="0" max="25"/></td></tr>
				<tr><td><label for"villeDepart">Ville Depart : </label></td>
					<td><input type="text" id="villeDepart" name="villeDepart" required/></td>
				<td><label for="paysDepart">Pays Depart : </label></td>
					<td><select name="paysDepart" size="1">
							<option value="nul" disabled checked>Séléctionnez un Pays</option>
						<?php
							for($i=0;$i<$nbLignes_pays;$i++){
								echo '<option value="'.$tab_pays[$i][0].'">'.$tab_pays[$i][1];
								echo '</option>';
							}
						?>
					</select></td></tr>

				<tr><td><label for"villeArrivee">Ville Arrivee : </label></td>
					<td><input type="text" id="villeArrivee" name="villeArrivee" required/></td>
				<td><label for="paysArrivee">Pays Arrivee : </label></td>
					<td><select name="paysArrivee" size="1">
							<option value="nul" disabled>Séléctionnez un Pays</option>
						<?php
							for($i=0;$i<$nbLignes_pays;$i++){
								echo '<option value="'.$tab_pays[$i][0].'">'.$tab_pays[$i][1];
								echo '</option>';
							}
						?>
					</select></td></tr>

				<tr><td><label for="distance">Distance : </label></td>
					<td><input type="number" id="distance" name="distance" min="0" step="any" style="width:100%" required/></td>
					<td><label for="moyenne">Moyenne : </label></td>
					<td><input type="number" id="moyenne" name="moyenne" min="0" step="any" style="width:100%"/></td></tr>
				<tr><td><label for="jour">Jour : </label></td>
					<td><input type="date" name="jour" style="width=100%" required/></td>
					<td><label for="typeEpreuve">Type d'Epreuve : </label></td>
					<td><select name="type" size="1">
							<?php
							foreach($tab_type as $i){
								echo '<option value="'.$i[0].'">'.utf8_encode($i[2]);
								echo '</option>';
							}
						?>
				
				<tr><td></br></td></tr>
				<tr style="text-align:center"><td colspan=2><input type="reset" id="annuler" value="Annuler"/></td>
							<td colspan=2><input type="submit" id="valider" value="Ajouter"/></td></tr>


			</table>

		</form>

		<?php
		if(isset($_POST['n_epreuve'])){

			$tab_verif=verif_inser_epreuve($_POST['annee'],$_POST['n_epreuve'],$_POST['villeDepart'],$_POST['paysDepart'],
					$_POST['villeArrivee'],$_POST['paysArrivee'],$_POST['distance'],$_POST['moyenne'],$_POST['jour'],$_POST['type']);

			if($tab_verif[0]){
				
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