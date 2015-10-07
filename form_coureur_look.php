<?php
	include("header.html");
?>
		<title>Formulaire Consultation Coureur</title>
		<h1 style='font-variant:small-caps'>Consultation des Coureurs de la Base</h1>

<?php
		include("fonc_oracle.php");
		include("log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT * FROM tdf_coureur order by n_coureur desc';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesCoureur($cur,$tab);
	    ?>
   
	   <table style="text-align:center;margin:auto">
	    	<tr style="font-weight:bold"><td>N_COUREUR</td><td align="center">NOM</td><td>PRENOM</td><td>CODE TDF</td><td>ANNEE NAISSANCE</td><td>ANNEE TDF</td><td colspan="2">OPERATIONS</td></tr>
	    <?php   
	    foreach($tab as $i){
	    	echo "<tr><td>$i[0]</td><td align='center'>$i[1]</td><td>".utf8_encode($i[2])."</td><td>$i[4]</td><td>$i[3]</td><td>$i[5]</td>";?>
	    			<form action="modif_coureur.php" method='POST'><td><input type='submit' name='modif' value='Modifier'/><?php echo "<input type=\"hidden\" name=\"n_coureur\" value=\"$i[0]\";/>"?></td></form>
	    			<form action="confirm_suppr_coureur.php" method='POST'><td><input type='submit' name='modif' value='Supprimer'/><?php echo "<input type=\"hidden\" name=\"n_coureur\" value=\"$i[0]\";/>"?></td></form>
	    	<?php echo"</tr>";
	    }
	    ?></table><?php
	    FermerConnexion($conn);

	    include("footer.html");