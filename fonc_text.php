<?php
function verif_caractere($chaine){
	$valid=true;
	$tab_nb=array('1','2','3','4','5','6','7','8','9','0');
	$carac_interdits=array("1","2","3","4","5","6","7","8","9","0",'_',".","\/",":"
							,"\?","!",",",";","§","$","%","µ","\*","\$","£","¤");

	foreach($carac_interdits as $carac_interdit)
		if ((preg_match("/$carac_interdit/", $chaine) or preg_match("/([']{2})/", $chaine) 
			or preg_match("/([ ]{2})/",$chaine)) and $valid==true)
			$valid=false;
	
	return $valid;
}

function remplace_accent($chaine){
	$nouv_chaine=strtolower($chaine);
	$nouv_chaine=preg_replace(utf8_decode("/[âäàÀÂÄ]/"),"a",$nouv_chaine);
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
	if(verif_caractere($chaine){
		$section_prenom=explode("/([- ])/", $chaine);
		foreach($section_prenom as $i){
			$premier_carac=substr($i, 0,1);
			$premier_carac=remplace_accent($premier_carac);
			$premier_carac=strtoupper($premier_carac);
			$i=$premier_carac.substr($i, 1);
		}
		$prenom
	}
	

}

$chaine1="Bo_njour";
$chaine1=utf8_decode($chaine1);
$chaine2="Bon  jour";
$chaine2=utf8_decode($chaine2);
$chaine3=utf8_decode("COmment ça và clËment");
echo "$chaine1 :";
if(verif_caractere($chaine1))echo "OK</br>";else echo"NOPE</br>";
echo "$chaine2 :";
if(verif_caractere($chaine2))echo "OK</br>";else echo"NOPE</br>";
echo remplace_accent($chaine3);
?>