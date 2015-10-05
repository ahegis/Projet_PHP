<html>
	<head>
		<title>Formulaire d'Ajout d'un Coureur</title>
		<meta charset="UTF-8"/>

		<script>
		   	function premierTDF(){
		   		val=parseInt(document.getElementById("anneeNaiss").value)+parseInt(18);
	    		document.getElementById("anneeTDF").min=val;
	    	}
		</script>
	</head>

	<body>
		<header style="text-align:center;font-size:40;color:darkblue">Mise à Jour de la Base TDF</header>

		<div> 	<table><tr>
					<td><a href="index.php">Accueil</a></td>
					<td style="border-right=0.5"><a href="select_consult.php" style="font-color:black">Consultation Tables</a></td>
					<td><a href="select_insert.php">Insertion dans une Table</a></td>
				</tr></table>

		</div>

		<?php
		include("fonc_oracle.php");
		include("fonc_text.php");
		$login = "copie_tdf";
      	$mdp = 'copie_tdf';
      	$instance = 'xe';
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesPays($cur,$tab);
		?>

		<form name="form_add" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
			<table>
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
				<tr><td><input type="reset" id="annuler" value="Annuler" style="margin:right"/></td>
							<td><input type="submit" id="valider" value="Ajouter"/></td></tr>


			</table>

		</form>

		<?php
		$valid=true;
		echo "<PRE>";
		print_r($_POST);
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
				if($anneeNaiss-$_POST['anneeTDF']>=0)
					$anneeTDF=$_POST['anneeTDF'];
				else $valid=false;
			else $valid=false;			
		
			if($valid){
			$req_numero='SELECT max(N_COUREUR) as num_max from tdf_coureur';
			$cur = PreparerRequete($conn,$req_numero);
	    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    	$nbLignes = LireDonnees1($cur,$tab);
	    	$n_coureur=$tab['NUM_MAX'][0]+1;
	    	
			$req_inser = 'INSERT INTO tdf_coureur (N_COUREUR,NOM,PRENOM,ANNEE_NAISSANCE,CODE_TDF,ANNEE_TDF) values ('.$n_coureur.',\''.$nom.'\',\''.$prenom.','.$anneeNaiss.','.$pays.'\','.$anneeTDF.')';
      		
      		echo $req_inser;
      		/*$cur = PreparerRequete($conn,$req_inser);
	    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
			
			$req_commit='COMMIT';
			$cur = PreparerRequete($conn,$req_commit);
	    	$res = ExecuterRequete($cur);*/
			}
			else echo "Champ(s) Invalide(s) (non rempli ou incorrect)";
		}
		else echo "valeur non définie";
		
		?>

	</body>


</html>