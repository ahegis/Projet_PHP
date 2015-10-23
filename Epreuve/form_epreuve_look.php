<?php
	include("../Core/header.html");
?>
		<title>Formulaire Consultation Epreuve</title>
		<h1 style='font-variant:small-caps'>Consultation des Epreuves de la Base</h1>

<?php
		include("../Fonctions/fonc_oracle.php");
		include("../Core/log_bdd.php");
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req_epreuve = 'SELECT * FROM tdf_epreuve order by annee desc,n_epreuve';
      	$cur = PreparerRequete($conn,$req_epreuve);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonneesEpreuve($cur,$tab_epreuve);
	    ?>
   
	   <table style="margin:auto">
	    	<tr style="font-weight:bold"><td >ANNEE</td><td align="center">N_EPREUVE</td><td>DEPART</td><td>ARRIVEE</td><td>DISTANCE</td><td>MOYENNE</td><td>TDF DEPART</td><td>TDF ARRIVEE</td><td>JOUR</td><td style="text-align:center">CAT CODE</td><td colspan="2">OPERATIONS</td></tr>
	    <?php   
	    foreach($tab_epreuve as $i){
	    	echo "<tr><td>$i[0]</td><td align='center'>$i[1]</td><td>".$i[2]."</td><td>$i[3]</td><td>$i[4]</td><td>$i[5]</td><td>$i[6]</td><td>$i[7]</td><td>$i[8]</td><td style=\"text-align:center\">$i[9]</td>";?>
	    			<?php /*<form action="modif_coureur.php" method='POST'><td><input type='submit' name='modif' value='Modifier'/><?php echo "<input type=\"hidden\" name=\"n_coureur\" value=\"$i[0]\";/>"?></td></form>
	    			<form action="confirm_suppr_coureur.php" method='POST'><td><input type='submit' name='modif' value='Supprimer'/><?php echo "<input type=\"hidden\" name=\"n_coureur\" value=\"$i[0]\";/>"?></td></form>
	    			*/?>
	    			<form action="form_epreuve_operation.php" method='POST'><td><input type='submit' name='modifier' value='Modifier'/><?php echo "<input type=\"hidden\" name=\"annee\" value=\"$i[0]\"/><input type=\"hidden\" name=\"n_epreuve\" value=\"$i[1]\"/>";?></td>
	    				<td><input type='submit' name='supprimer' value='Supprimer'/></td></form>
	    	<?php echo"</tr>";
	    }
	    ?></table><?php

	    /*<*/
	    FermerConnexion($conn);

	    include("../Core/footer.html");