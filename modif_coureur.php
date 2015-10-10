<?php
	include("header.html");
?>
		<title>Modification Coureur</title>
		<h1 style='font-variant:small-caps'>Modification d'un Coureur de la Base</h1>

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
		
		if(isset($_POST["confirmer"])){
			$tab_verif=verif_valeur_inser($_POST['nom'],$_POST['prenom'],$_POST['anneeNaiss'],$_POST['pays'],$_POST['anneeTDF']);
			
		    if($tab_verif[0]){
				$req_numero='SELECT max(N_COUREUR) as num_max from tdf_coureur';
				$cur = PreparerRequete($conn,$req_numero);
		    	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
		    	$nbLignes = LireDonnees1($cur,$tab);
				$req_update = "UPDATE tdf_coureur set
								NOM='".$tab_verif[1]."',
								PRENOM='".$tab_verif[2]."',
								ANNEE_NAISSANCE=".$tab_verif[3].",
								CODE_TDF='".$tab_verif[4]."',
								ANNEE_TDF=".$tab_verif[5]." WHERE N_COUREUR=".$_POST['n_coureur'];
	      		
	      		if(!exist_coureur_update($_POST['n_coureur'],$tab_verif[1],$tab_verif[2],$tab_verif[4])){
	      			$cur = PreparerRequete($conn,$req_update);
		    		$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
					$req_commit='COMMIT';
					$cur = PreparerRequete($conn,$req_commit);
		    		$res = ExecuterRequete($cur);
		    		?><script>window.alert("Coureur Modifié");</script><?php
		    	}
		    	else {?><script>window.alert("Impossible de modifier le coureur");</script><?php echo "";}
			}
			else {?><script>window.alert("Champ(s) Invalide(s) ( Incomplet(s) ou Vide(s) )");</script><?php echo "";}
		}

			
		else if(isset($_POST["annuler"])){
			header("location:form_coureur_look.php");
		}

      	
      	$selec_suppr = 'SELECT * FROM tdf_coureur WHERE N_COUREUR=\''.$_POST['n_coureur'].'\'';
      	$cur = PreparerRequete($conn,$selec_suppr);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesCoureur($cur,$tab);

	    $req_pays = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
      	$cur = PreparerRequete($conn,$req_pays);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignesPays = LireDonneesPays($cur,$tab_pays);
	?>    

	<table style="margin:auto"><tr><td colspan=5 style="text-align:center;font-weight:bold;padding-bottom:30px">Modification du Coureur</td></tr>
			<tr><td>N° COUREUR : </td><td><?php echo $tab[0][0];?></td>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">	
				<td>PAYS : </td>
				<td><select name="pays" size="1">
							<option value="nul" disabled checked>Séléctionnez un Pays</option>
						<?php
							for($i=0;$i<$nbLignesPays;$i++){
								if($tab_pays[$i][0]==$tab[0][4])
									echo '<option value="'.$tab_pays[$i][0].'" selected>'.$tab_pays[$i][1];
								else echo '<option value="'.$tab_pays[$i][0].'">'.$tab_pays[$i][1];
								echo '</option>';
							}
						?>
					</select></td></tr>

			<tr><td>NOM : </td>
				<td><?php echo "<input type='text' name='nom' value='".$tab[0][1]."'style='width:100%'/></td>";?>
				<td>PRENOM : </td>
				<td><?php echo "<input type='text' name='prenom' value='".utf8_encode($tab[0][2])."' style='width:100%'/></td></tr>";?>
			
			<tr><td>ANNEE NAISSANCE : </td>
				<td><?php echo '<input type="number" id="anneeNaiss" name="anneeNaiss" min="'.(date('Y')-100).'"'.'max="'.(date('Y')-18).'"'.'onclick="premierTDF()" style="width:100%" value="'.$tab[0][3].'"/></td>'?>
				<td>ANNEE TDF : </td>
				<td><input type="number" id="anneeTDF" name="anneeTDF" min="" max="" style="width:100%" value="<?php echo $tab[0][5];?>"/></td></tr>	


			
				<tr><td colspan=2 style="text-align:right;padding-top:20px"><input type="submit" name="annuler" value="Annuler"/><input type="hidden" name="n_coureur" value=<?php echo '"'.$tab[0][0].'"';?> </td><td style="padding-top:20px"><input type="submit" name="confirmer" value="Confirmer"/></td></tr></form>
	</table>

<?php
		
		



		include("footer.html");