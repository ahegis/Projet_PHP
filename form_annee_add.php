<?php
	include("header.html");
?>
	<title>Formulaire Ajout Annee</title>
	<h1 style='font-variant:small-caps;text-align:center'>Ajout d'une Annee dans la Base</h1>

		<?php
		include("fonc_oracle.php");
		include("fonc_text.php");
		include("fonc_sql.php");
		include("log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur);
	    $nbLignes = LireDonneesPays($cur,$tab);
		?>

		<form name="form_add" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >
			<table style="margin:auto">
				<tr><td><label for="annee">ANNEE : </label></td>
					<td><input type="number" name="annee" min="1903"/></td></tr>
				<tr><td><label for="nb_repos">NB JOUR REPOS : </label></td>
					<td><input type="number" name="nb_repos" min="0"/></td></tr>
				<tr style="text-align:center"><td><input type="reset" id="annuler" value="Annuler"/></td>
							<td><input type="submit" id="valider" name="valider" value="Ajouter"/></td></tr>


			</table>

		</form>

		<?php

		if(isset($_POST['valider'])){

      		$req_annee = 'SELECT * FROM tdf_annee';
      		$cur = PreparerRequete($conn,$req_annee);
	    	$res = ExecuterRequete($cur);
	    	$nbLignes = LireDonnees2($cur,$tab_annee);

	    	$valid=false;

	    	for($i=0;$i<sizeof($tab_annee);$i++){
	    		if($tab_annee[$i][0]==$_POST['annee'])$valid=true;
	    	}

	    	if($_POST['nb_repos']>=0 && $_POST['nb_repos']<10)$valid=true;

	    	if($valid){
      			if(!exist_annee($_POST['annee'])){
	      			$req_annee_inser = 'INSERT INTO tdf_annee (ANNEE,JOUR_REPOS) values ('.$_POST['annee'].','.$_POST['nb_repos'].')';
	      			echo $req_annee_inser;
	      			$cur = PreparerRequete($conn,$req_annee_inser);
		    		$res = ExecuterRequete($cur);
		    		$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
		    		$res = ExecuterRequete($cur);
		    	}
		    	else echo "Annee deja existante";
	    	}
		}

		include("footer.html");