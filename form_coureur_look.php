<html>
	<head>
		<title>Formulaire de Consultation des Coureurs</title>
		<meta charset="UTF-8">
	</head>

	<body>
		<?php
		include("fonc_oracle.php");

	  	$login = "copie_tdf";
      	$mdp = 'copie_tdf';
      	$instance = 'xe';
      	$conn = OuvrirConnexion($login, $mdp,$instance);
      	$req = 'SELECT * FROM tdf_coureur order by nom';
      	$cur = PreparerRequete($conn,$req);
	    $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	    $nbLignes = LireDonnees2($cur,$tab);
	    ?>
	    <?php
	    echo "<PRE>";
	    print_r($tab);

	   /*
	   <table>
	    	<tr><td><b>N_COUREUR	 </b></td><td align="center"><b>	NOM</b></td><td><b>PRENOM</b></td></tr>
	    <?php   
	    foreach($tab as $i){
	    	echo "<tr><td>$i[0]</td><td align='center'>$i[1]</td><td>$i[2]</td></tr>";
	    }
	    ?></table>*/
	    FermerConnexion($conn);

	    ?>











		?>
	</body>
</html>