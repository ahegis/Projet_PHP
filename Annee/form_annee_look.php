<?php
	include("../Core/header.html");
?>
		<title>Formulaire Consultation Annee</title>
		<h1 style='font-variant:small-caps'>Consultation des Annees de la Base</h1>

<?php
		include("../Fonctions/fonc_oracle.php");
		include("../Core/log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT * FROM tdf_annee order by annee desc';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesAnnee($cur,$tab);
	    ?>
   
	   <table style="text-align:center;margin:auto">
	    	<tr style="font-weight:bold"><td>ANNEE</td><td align="center">NB JOUR REPOS</td><td colspan="2">OPERATIONS</td></tr>
	    <?php   
	    foreach($tab as $i){
	    	echo "<tr><td>$i[0]</td><td align='center'>$i[1]</td>";?>
	    			<form action="form_annee_operation.php" method='POST'><td><input type='submit' name='modif' value='Modifier'/><?php echo "<input type=\"hidden\" name=\"annee\" value=\"$i[0]\";/>"?></td>
						<td><input type='submit' name='modif' value='Supprimer'/></td></form>
	    	<?php echo"</tr>";
	    }
	    ?></table><?php
	    FermerConnexion($conn);

	    include("../Core/footer.html");