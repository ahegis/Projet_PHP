<?php
	include("header.html");
?>

<title>Formulaire Operation Annee</title>
		<h1 style='font-variant:small-caps'>Opération sur une Annee de la Base</h1>


<?php
		include("fonc_oracle.php");
		include("fonc_sql.php");
		include("fonc_text.php");
		include("log_bdd.php");
<<<<<<< HEAD
      	if(isset($_POST['annee'])){
	      	$conn = OuvrirConnexion($login, $mdp,$instance);
	      	$selec_suppr = 'SELECT * FROM tdf_annee WHERE ANNEE=\''.$_POST['annee'].'\'';
	      	$cur = PreparerRequete($conn,$selec_suppr);
		    $res = ExecuterRequete($cur);
		    $nbLignes = LireDonneesAnnee($cur,$tab_annee);
		}	    	
=======
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$selec_suppr = 'SELECT ANNEE,JOUR_REPOS FROM tdf_annee WHERE ANNEE=\''.$_POST['annee'].'\'';
      	$cur = PreparerRequete($conn,$selec_suppr);
	    $res = ExecuterRequete($cur);
	    $nbLignes = LireDonneesAnnee($cur,$tab_annee);

>>>>>>> origin/master
	    //si l'on choisit "supprimer" depuis le formulaire de consultation
	    if((isset($_POST['modif']) && $_POST['modif']=="Supprimer") || (isset($_POST['action']) && $_POST['action']=="supprimer")){
	    	?>


	    	<table style="margin:auto">
	    		<tr><td colspan=5 style="text-align:center;font-weight:bold;padding-bottom:30px">Etes-vous sur de vouloir supprimer cette annee de la base ?</td></tr>
				<tr><td>ANNEE : </td><td style="padding-right:50px"><?php echo $tab_annee[0][0];?></td>
					<td>NB JOURS REPOS : </td><td><?php echo $tab_annee[0][1];?></td></tr>
				
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<tr><td colspan=2 style="text-align:right;padding-top:20px"><input type="submit" name="annuler" value="NON"/><input type="hidden" name="annee" value=<?php echo '"'.$tab_annee[0][0].'"';?> /><input type="hidden" name="action" value="supprimer"/></td>
					<td style="padding-top:20px"><input type="submit" name="confirmer" value="OUI"/></td></tr></form>
			</table>

			<?php
		
			if(isset($_POST["confirmer"])){
<<<<<<< HEAD
				if(exist_participation($_POST['annee'])==0){
					echo exist_participation($_POST['annee']);
=======
				if(exist_lien_annee($_POST['annee'])==0){
>>>>>>> origin/master
					$req_suppr = 'DELETE FROM tdf_annee WHERE ANNEE=\''.$_POST['annee'].'\'';
					$cur = PreparerRequete($conn,$req_suppr);
			    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
			    	$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
				    $res = ExecuterRequete($cur);
				    header("location:form_annee_look.php");
				}
<<<<<<< HEAD
				else {?><script>window.alert("Impossible de supprimer l'année, elle est associée à au moins une entrée dans la base");</script><?php
=======
				else {?><script>window.alert("Impossible de supprimer l'année, il est associé à au moins une ligne de la base");</script><?php
>>>>>>> origin/master
					echo "";}
			}
			else if(isset($_POST["annuler"])){
				header("location:form_annee_look.php");
			}
	    }
	    

	    //si l'on choisit "modifier" depuis le formulaire de consultation
	    else if((isset($_POST['modif']) && $_POST['modif']=="Modifier") || (isset($_POST['action']) && $_POST['action']=="modifier")){
	    	
<<<<<<< HEAD
		    if(isset($_POST["confirmer"])){
					$tab_verif=verif_update_annee($_POST['annee'],$_POST['n_repos']);
				
			    if($tab_verif[0]){
					
					$req_update = "UPDATE tdf_annee SET
								JOUR_REPOS=".$tab_verif[2]." WHERE ANNEE=".$tab_verif[1];
		      		
		      		$cur = PreparerRequete($conn,$req_update);
			    	$res = ExecuterRequete($cur);
					$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
			    	$res = ExecuterRequete($cur);
			    	?><script>window.alert("Annee Modifié");</script><?php
			    	header("location:form_annee_look.php");
				}
				else {?><script>window.alert("Champ(s) Invalide(s) ( Incomplet(s) ou Vide(s) )");</script><?php echo "";}
			}
=======
	    	if(isset($_POST["confirmer"])){
				$tab_verif=verif_inser_annee($_POST['annee'],$_POST['n_repos']);
			
		    if($tab_verif[0]){
				$req_numero='SELECT max(N_COUREUR) as num_max from tdf_coureur';
				$cur = PreparerRequete($conn,$req_numero);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
		    	$nbLignes = LireDonnees1($cur,$tab);
				$req_update = "UPDATE tdf_annee set
								JOUR_REPOS='".$tab_verif[2]."' WHERE ANNEE=".$_POST['annee'];
	      	
	      		$cur = PreparerRequete($conn,$req_update);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
				$req_commit='COMMIT';
				$cur = PreparerRequete($conn,$req_commit);
		    	$res = ExecuterRequete($cur);
		    	?><script>window.alert("Annee Modifié");</script><?php
		    	header("location:form_annee_look.php");
		    }
			else {?><script>window.alert("Champ(s) Invalide(s) ( Incomplet(s) ou Vide(s) )");</script><?php echo "";}
		}
>>>>>>> origin/master

			
			else if(isset($_POST["annuler"])){
				header("location:form_annee_look.php");
			}

	    ?>
	    	

<<<<<<< HEAD
	   		<table style="margin:auto">
		    	<tr><td colspan=5 style="text-align:center;font-weight:bold;padding-bottom:30px">Modification du Coureur</td></tr>
				<tr><td>ANNEE : </td><td><?php echo $tab_annee[0][0];?></td></tr>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">	
					<tr><td>NB JOURS REPOS : </td><td><?php echo "<input type='number' name='n_repos' value='".$tab_annee[0][1]."' min='0' style='width:100%'/></td>";?>
				
					<tr><td colspan=2 style="text-align:right;padding-top:20px"><input type="submit" name="annuler" value="Annuler"/><input type="hidden" name="annee" value=<?php echo '"'.$tab_annee[0][0].'"';?> /><input type="hidden" name="action" value="modifier"/></td>
						<td style="padding-top:20px"><input type="submit" name="confirmer" value="Confirmer"/></td></tr>
				</form>
			</table>
=======
	    	<table style="margin:auto"><tr><td colspan=5 style="text-align:center;font-weight:bold;padding-bottom:30px">Modification du Coureur</td></tr>
			<tr><td>ANNEE : </td><td><?php echo $tab_annee[0][0];?></td></tr>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">	
				<tr><td>NB JOURS REPOS : </td><td><?php echo "<input type='number' name='n_repos' value='".$tab_annee[0][1]."' min='0' max='9'style='width:100%'/></td>";?>
				
			
				<tr><td colspan=2 style="text-align:right;padding-top:20px"><input type="submit" name="annuler" value="Annuler"/><input type="hidden" name="annee" value=<?php echo '"'.$tab_annee[0][0].'"';?> /><input type="hidden" name="action" value="modifier"/></td>
					<td style="padding-top:20px"><input type="submit" name="confirmer" value="Confirmer"/></td></tr></form>
	</table>
>>>>>>> origin/master

<?php
		}


	include("footer.html");
