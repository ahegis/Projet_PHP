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

function verif_inser_coureur($nom,$prenom,$anneeNaiss,$pays,$anneeTDF){
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

function verif_update_annee($annee,$nb_jour){
	include("log_bdd.php");
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$req_annee = 'SELECT annee FROM tdf_annee';
	$nbLignes = ResultatRequete($conn,$req_annee,$tab_annee);
	print_r($tab_annee);
	$tab[0]=true;

	$annee_valid=false;
	for($i=0;$i<$nbLignes;$i++){
		if($annee==$tab_annee['ANNEE'][$i])$annee_valid=true;
	}
	if($annee_valid)$tab[1]=$annee;
	else $tab[0]=false;

	if($nb_jour>=0 && $nb_jour<10)$tab[2]=$nb_jour;
	else $tab[0]=false;

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
	$nbLignes = ResultatRequete($conn,$req,$tab);
	if(isset($nbLignes)){	
		if ($nbLignes>=1)return true;
		else return false;
	}
}

function verif_utilise_annee($annee){
	include("log_bdd.php");
	$conn = OuvrirConnexion($login, $mdp,$instance);
	$req_annee_participation = 'SELECT * FROM tdf_participation WHERE ANNEE='.$annee;
	$req_annee_equipe_annee = 'SELECT * FROM tdf_equipe_annee WHERE ANNEE='.$annee;
	$req_annee_epreuve = 'SELECT * FROM tdf_epreuve WHERE ANNEE='.$annee;
	$req_annee_ordrequi = 'SELECT * FROM tdf_ordrequi WHERE ANNEE='.$annee;
	$req_annee_temps_difference = 'SELECT * FROM tdf_temps_difference WHERE ANNEE='.$annee;
	$req_annee_abandon = 'SELECT * FROM tdf_abandon WHERE ANNEE='.$annee;
	$req_annee_temps = 'SELECT * FROM tdf_temps WHERE ANNEE='.$annee;


}
?>