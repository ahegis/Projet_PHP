<?php


function exist_coureur_inser($nom,$prenom,$code_tdf){
	include("log_bdd.php");
	$req_verif_inser='SELECT * FROM tdf_coureur WHERE NOM=\''.$nom.'\' AND PRENOM=\''.$prenom.'\' AND CODE_TDF=\''.$code_tdf.'\'';
    $conn = OuvrirConnexion($login, $mdp,$instance);
	$cur = PreparerRequete($conn,$req_verif_inser);
	$res = ExecuterRequete($cur);
	$nbLignes = LireDonnees2($cur,$tab);
	if(isset($nbLignes)){	
		if ($nbLignes==0)return false;
		else return true;
	}
}

function exist_coureur_suppr($n_coureur,$nom,$prenom,$code_tdf){
	include("log_bdd.php");
	$req_verif_suppr='SELECT * FROM tdf_coureur WHERE NOM=\''.$nom.'\' AND PRENOM=\''.$prenom.'\' AND CODE_TDF=\''.$code_tdf.'\'';
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$cur = PreparerRequete($conn,$req_verif_suppr);
	$res = ExecuterRequete($cur);
	$nbLignes = LireDonnees2($cur,$tab);
	if(isset($nbLignes)){	
		if ($nbLignes==1)return true;
		else return false;
	}
}




?>