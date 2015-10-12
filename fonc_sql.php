<?php


function exist_coureur_inser($nom,$prenom,$code_tdf){
	include("log_bdd.php");
	$req_verif_inser='SELECT * FROM tdf_coureur WHERE NOM=\''.$nom.'\' AND PRENOM=\''.$prenom.'\' AND CODE_TDF=\''.$code_tdf.'\'';
    $conn = OuvrirConnexion($login, $mdp,$instance);
	$cur = PreparerRequete($conn,$req_verif_inser);
	$res = ExecuterRequete($cur);
	$nbLignes = LireDonneesCoureur($cur,$tab);
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
	$nbLignes = LireDonneesCoureur($cur,$tab);
	if(isset($nbLignes)){	
		if ($nbLignes==1)return true;
		else return false;
	}
}

function exist_coureur_update($n_coureur,$nom,$prenom,$code_tdf){
	include("log_bdd.php");
	$req_verif_update='SELECT * FROM tdf_coureur WHERE NOM=\''.$nom.'\' AND PRENOM=\''.$prenom.'\' AND CODE_TDF=\''.$code_tdf.'\'';
    $conn = OuvrirConnexion($login, $mdp,$instance);
	$cur = PreparerRequete($conn,$req_verif_update);
	$res = ExecuterRequete($cur);
	$nbLignes = LireDonneesCoureur($cur,$tab);

	if(isset($nbLignes)){	
		if ($nbLignes==0 or($nbLignes==1 and $tab[0][0]==$n_coureur))return false;
		else return true;
	}
}

function verif_valeur_inser($nom,$prenom,$anneeNaiss,$pays,$anneeTDF){
	include("log_bdd.php");
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$req_pays = 'SELECT code_tdf,nom FROM tdf_pays order by nom';
	$cur = PreparerRequete($conn,$req_pays);
	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	$nbLignes = LireDonneesPays($cur,$tab_pays);

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
					if((date('Y')-$anneeNaiss)>=18)$tab[3]=$anneeNaiss;
					else {
						$tab[0]=false;
						$tab[3]='null';
					}
				else $tab[3]='null';

				if(isset($pays)){
					$pays_valid=false;
					for($i=0;$i<$nbLignes;$i++){
						if($pays==$tab_pays[$i][0])$pays_valid=true;
					}
					if($pays_valid)$tab[4]=$pays;
				}
				else $tab[0]=false;

				if(isset($anneeTDF) and $anneeTDF!="")
					if($tab[3]-$anneeNaiss>=0)
						$tab[5]=$anneeTDF;
					else $tab[0]=false;
				else $tab[5]='null';
	}


	return $tab;
}

function exist_participation($n_coureur){
	include("log_bdd.php");
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$req = 'SELECT * FROM tdf_participation WHERE N_COUREUR='.$n_coureur;
	$cur = PreparerRequete($conn,$req);
	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	$nbLignes = LireDonnees1($cur,$tab);
	return $nbLignes;

}

function exist_annee($annee){
	include("log_bdd.php");
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$req = 'SELECT * FROM tdf_annee WHERE ANNEE='.$annee;
	$cur = PreparerRequete($conn,$req);
	$res = ExecuterRequete($cur); // Attention, pas &$nbLignes
	$nbLignes = LireDonnees1($cur,$tab);
	if(isset($nbLignes)){	
		if ($nbLignes>=1)return true;
		else return false;
	}
}
?>