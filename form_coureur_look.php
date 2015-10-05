<?php
	include("header.html");
?>
		<title>Formulaire Ajout Coureur</title>
		<h1 style='font-variant:small-caps'>Consultation des Coureurs de la Base</h1>
<?php
		include("fonc_oracle.php");

	  	$login = "copie_tdf";
      	$mdp = 'copie_tdf';
      	$instance = 'xe';
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT * FROM tdf_coureur order by n_coureur desc';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonnees2($cur,$tab);
	    ?>
   
	   <table style="text-align:center;margin:auto">
	    	<tr><td><b>N_COUREUR	 </b></td><td align="center"><b>	NOM</b></td><td><b>PRENOM</b></td><td colspan="2"><b>OPERATIONS</b></td></tr>
	    <?php   
	    foreach($tab as $i){
	    	echo "<tr><td>$i[0]</td><td align='center'>$i[1]</td><td>".utf8_encode($i[2])."</td>"?><form action="<?php $_SERVER['PHP_SELF'] ?>" method='POST'><td><input type='submit' name='modif' value='Modifier'/><input type="hidden" name="n_coureur" value=<?php echo"$i[0]";?></td><td><input type="submit" name="suppr" value="Supprimer"/></td></form><?php echo"</tr>";
	    }
	    ?></table><?php
	    FermerConnexion($conn);

	    if(isset($_POST['modif'])){

	    }
	    else if(isset($_POST['suppr'])){
	    	$req_suppr='DELETE FROM tdf_coureur WHERE n_coureur='.$_POST['n_coureur'];
	    	echo ($req_suppr);
	    }

	    include("footer.html");