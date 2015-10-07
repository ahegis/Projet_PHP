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

/*function verif_valeur_inser($nom,$prenom,$anneeNaiss,$pays,$anneeTDF){
$tab[0]=true;
	if(isset($nom)){

			if(isset($nom))
				if(verif_caractere($nom))
					$tab[1]=valid_nom($nom);
				else $tab[0]=false;
			else $tab[0]=false;

			if(isset($prenom))
				if(verif_caractere($prenom))
					$tab[2]=valid_prenom($prenom);
				else $tab[0]=false;
			else $tab[0]=false;

			if(isset($anneeNaiss) and $anneeNaiss!="")
				$tab[3]=$anneeNaiss;
			else $tab[3]='null';

			if(isset($pays)){
				$pays_valid=false;
				for($i=0;$i<$nbLignes;$i++){
					if($code_tdf==$tab[$i][0])$pays_valid=true;
				}
				if($pays_valid)$tab[4]=$code_tdf;
			}
			else $tab[0]=false;

			if(isset($anneTDF) and $anneTDF!="")
				if($anneTDF-$anneeNaiss>=0)
					$tab[5]=$anneTDF;
				else $tab[0]=false;
			else $tab[5]='null';
}


return $tab;
}*/
?>