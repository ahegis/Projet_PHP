<?php
function verif_caractere($chaine){
	$valid=true;
	$carac_interdits=array("1","2","3","4","5","6","7","8","9","0",'_',"\.","\/","\:"
							,'\?',"!",",",";","§","%","µ","\*","£","¤","\"");
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

function remplace_accent($chaine){
	$nouv_chaine=strtolower($chaine);	

	$nouv_chaine=(preg_replace(utf8_decode("/[âäàÀÂÄ]/"),"a",$nouv_chaine));
	$nouv_chaine=preg_replace(utf8_decode("/[çÇ]/"),"c",$nouv_chaine);
	$nouv_chaine=preg_replace(utf8_decode("/([éèêëÉÈÊË])/"),"e",$nouv_chaine);
	$nouv_chaine=preg_replace(utf8_decode("/[îïÎÏ]/"),"i",$nouv_chaine);
	$nouv_chaine=preg_replace(utf8_decode("/[öôÔÖ]/"),"o",$nouv_chaine);
	$nouv_chaine=preg_replace(utf8_decode("/[ùûüÙÛÜ]/"),"u",$nouv_chaine);
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
				$premier_carac=substr($section_prenom[$i][$j],0,1);
				$premier_carac=remplace_accent($premier_carac);
				$premier_carac=strtoupper($premier_carac);
				$section_prenom[$i][$j]=$premier_carac.substr($section_prenom[$i][$j], 1);
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
	else return false;

}

$chaine1="Ëlément";
$chaine2="Bon  jour";
$chaine3="COmment ça và clËment";
echo utf8_decode($chaine1)." :";
if(verif_caractere($chaine1))echo "OK</br>";else echo"NOPE</br>";
echo "$chaine2 :";
if(verif_caractere($chaine2))echo "OK</br>";else echo"NOPE</br>";
//echo remplace_accent($chaine3);
$chaine4=" jéan-Ëu Dñe";
if(valid_prenom($chaine4))
	echo "</br>".utf8_decode($chaine4)." => ".valid_prenom($chaine4);
else echo "</br> Erreur Validation Prenom";
?>