<?php
function verif_caractere($chaine){
	$valid=true;
	$carac_interdits=array("1","2","3","4","5","6","7","8","9","0",'_',"\.","\/","\:"
							,'\?',"!",",",";","§","%","µ","\*","£","¤","\"","€","~");
	
	/*$carac_auto=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
			"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
			" ","-","'","â","ä","à","À","Â","Ä","ç","Ç","é","è","ê","ë","É","È","Ê","Ë","î","ï","Î","Ï","ö","ô","Ô","Ö","ù","û","ü","Ù","Û","Ü","æ","Æ");*/
	foreach($carac_interdits as $i){
		$i=utf8_encode($i);
	}
	foreach($carac_interdits as $carac_interdit){
		if ((preg_match("/$carac_interdit/", $chaine) or preg_match("/([']{2})/", $chaine) 
			or preg_match("/([ ]{2})/",$chaine)) and $valid==true)
			$valid=false;
	}
	return $valid;
}

function remplace_accent($chaine,$ok){
	$nouv_chaine=strtolower($chaine);	

	if($ok){
		$nouv_chaine=(preg_replace(utf8_decode("/[âäàÀÂÄ]/"),"a",$nouv_chaine));
		$nouv_chaine=preg_replace(utf8_decode("/[çÇ]/"),"c",$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/([éèêëÉÈÊË])/"),"e",$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[îïÎÏ]/"),"i",$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[öôÔÖ]/"),"o",$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[ùûüÙÛÜ]/"),"u",$nouv_chaine);
	}
	else{
		$nouv_chaine=preg_replace(utf8_decode("/[Â]/"),utf8_decode("â"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ä]/"),utf8_decode("ä"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[À]/"),utf8_decode("à"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ç]/"),utf8_decode("ç"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[É]/"),utf8_decode("é"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[È]/"),utf8_decode("è"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ê]/"),utf8_decode("ê"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ë]/"),utf8_decode("ë"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Î]/"),utf8_decode("î"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ï]/"),utf8_decode("ï"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ô]/"),utf8_decode("ô"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ö]/"),utf8_decode("ö"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Û]/"),utf8_decode("û"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ü]/"),utf8_decode("ü"),$nouv_chaine);
		$nouv_chaine=preg_replace(utf8_decode("/[Ù]/"),utf8_decode("û"),$nouv_chaine);
	}
	$nouv_chaine=preg_replace(utf8_decode("/[æÆ]/"),"ae",$nouv_chaine);
	$nouv_chaine=preg_replace(utf8_decode("/[œŒ]/"),"oe",$nouv_chaine);
	return $nouv_chaine;
}

function valid_prenom($chaine){
	$prenom="";
	$explo_prenom="";
	$chaine=utf8_decode($chaine);
	if(verif_caractere($chaine)){
		$section_prenom=explode(" ", trim($chaine));
		for($a=0;$a<sizeof($section_prenom);$a++){
			$section_prenom[$a]=explode("-",$section_prenom[$a]);
		}
		
		for($i=0;$i<sizeof($section_prenom);$i++){
			for($j=0;$j<sizeof($section_prenom[$i]);$j++){
				$cpt=0;
				do{
					$premier_carac=substr($section_prenom[$i][$j],0,$cpt+1);
					$cpt++;
				}while($premier_carac=="'" && $cpt<sizeof($section_prenom[$i]));
				$premier_carac=remplace_accent($premier_carac,1);
				$premier_carac=strtoupper($premier_carac);
				$section_prenom[$i][$j]=$premier_carac.remplace_accent(substr($section_prenom[$i][$j], $cpt),0);
			}
		}

		for($k=0;$k<sizeof($section_prenom);$k++){
			$explo_prenom="";
			for($l=0;$l<sizeof($section_prenom[$k]);$l++){
				if($l!=0)$explo_prenom=$explo_prenom."-".$section_prenom[$k][$l];
				else $explo_prenom=$section_prenom[$k][$l];
			}
			if($k!=0)$prenom=$prenom." ".$explo_prenom;
			else $prenom=$explo_prenom;
		}
		return $prenom;
	}
	else return "interdit";

}

function valid_nom($chaine){
	$nom="";
	$explo_nom="";
	$chaine=utf8_decode($chaine);
	if(verif_caractere($chaine)){
		$section_nom=explode(" ", trim($chaine));
		for($a=0;$a<sizeof($section_nom);$a++){
			$section_nom[$a]=explode("-",$section_nom[$a]);
		}
		
		for($i=0;$i<sizeof($section_nom);$i++){
			for($j=0;$j<sizeof($section_nom[$i]);$j++){
				$chaine_inter=remplace_accent($section_nom[$i][$j],1);
				$section_nom[$i][$j]=strtoupper($chaine_inter);
				
			}
		}

		for($k=0;$k<sizeof($section_nom);$k++){
			$explo_nom="";
			for($l=0;$l<sizeof($section_nom[$k]);$l++){
				if($l!=0)$explo_nom=$explo_nom."-".$section_nom[$k][$l];
				else $explo_nom=$section_nom[$k][$l];
			}
			if($k!=0)$nom=$nom." ".$explo_nom;
			else $nom=$explo_nom;
		}
		return $nom;
	}
	else return "interdit";
}

function test_fonction($tab_test){
	echo "<table border=1><tr><td>Depart</td>";
	echo "<td>Nom</td><td>Prenom</td></tr>";
	foreach($tab_test as $case_tab_test){
		echo "<tr><td>".utf8_decode($case_tab_test)."</td>";
		echo "<td>".utf8_decode(valid_nom($case_tab_test))."</td>";
		echo "<td>".valid_prenom($case_tab_test)."</td>";
		echo "</tr>";
	}
	echo "</table>";

}

function test_var_vide($chaine){
	if(isset($chaine))return $chaine;
	else return "'null'";
}


/*
$chaine1="Ëlément";
$chaine2="Bon  jour";
$chaine3="COmment ça và clËment";
echo utf8_decode($chaine1)." :";
if(verif_caractere($chaine1))echo "OK</br>";else echo"NOPE</br>";
echo "$chaine2 :";
if(verif_caractere($chaine2))echo "OK</br>";else echo"NOPE</br>";
//echo remplace_accent($chaine3);
$chaine4=" jéan-Ëu Dñe";
echo "'"==utf8_decode("'");
if(valid_prenom($chaine4)!="interdit")
	echo "</br>".utf8_decode($chaine4)." => ".valid_prenom($chaine4);
else echo "</br> Erreur Validation Prenom";

$tab_test=array("Ébé-ébé","ébé-ébé","ébé-Ébé","éÉé-Ébé","'éÉ'é-É'bé'"
	,"'éæé-É'bé'","'éæé-É'Ŭé'","'é !é-É'Ŭé'","éé''éé--uù  gg","DE LA TR€UC","DE LA TRUC",
	"ééééééééééééééééééééééééééééééééééééééééééééééé","-péron-de - la   branche-");
test_fonction($tab_test);*/

?>