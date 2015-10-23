<?php
	include("header.html");
?>
		<title>Confirmation Suppression Coureur</title>
		<h1 style='font-variant:small-caps'>Suppression d'un Coureur de la Base</h1>

<?php
		include("../Fonctions/fonc_oracle.php");
		include("../Fonctions/fonc_sql.php");
		include("../Core/log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$selec_suppr = 'SELECT * FROM tdf_coureur WHERE N_COUREUR=\''.$_POST['n_coureur'].'\'';
      	$cur = PreparerRequete($conn,$selec_suppr);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesCoureur($cur,$tab);
	?>    

	<table style="margin:auto"><tr><td colspan=5 style="text-align:center;font-weight:bold;padding-bottom:30px">Etes-vous sur de vouloir supprimer ce coureur de la base ?</td></tr>
			<tr><td colspan=2><?php echo $tab[0][0];?></td><td><?php echo $tab[0][4]?></td></tr>
			<tr><td>NOM : </td><td style="padding-right:50px"><?php echo $tab[0][1];?></td><td>PRENOM : </td><td><?php echo utf8_encode($tab[0][2]);?></td></tr>
			<tr><td>ANNEE NAISSANCE : </td><td style="padding-right:30px"><?php echo $tab[0][3];?></td><td>ANNEE TDF : </td><td><?php echo $tab[0][5];?></td></tr>

			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				<tr><td colspan=2 style="text-align:right;padding-top:20px"><input type="submit" name="annuler" value="NON"/><input type="hidden" name="n_coureur" value=<?php echo '"'.$tab[0][0].'"/>';?> </td><td style="padding-top:20px"><input type="submit" name="confirmer" value="OUI"/></td></tr></form>
	</table>

<?php
		
		if(isset($_POST["confirmer"])){
			if(exist_participation($_POST['n_coureur'])==0){
				echo exist_participation($_POST['n_coureur']);
				$req_suppr = 'DELETE FROM tdf_coureur WHERE N_COUREUR=\''.$_POST['n_coureur'].'\'';
				$cur = PreparerRequete($conn,$req_suppr);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
		    	$req_commit='COMMIT';
				$cur = PreparerRequete($conn,$req_commit);
			    $res = ExecuterRequete($cur);
			    header("location:form_coureur_look.php");
			}
			else {?><script>window.alert("Impossible de supprimer le coureur, il est associé à au moins une participation");</script><?php
				echo "";}
		}
		else if(isset($_POST["annuler"])){
			header("location:form_coureur_look.php");
		}



		include("footer.html");