<?php
// E.Porcq  fonc_oracle.php  12/10/2009 

//---------------------------------------------------------------------------------------------
function OuvrirConnexion($session,$mdp,$instance)
{
  @$conn = oci_connect($session, $mdp,$instance);
  if (!$conn) //si pas de connexion retourne une erreur
  {  
	@$e = oci_error();
	//avec un message pour pouvoir revenir à la page de connexion
  switch($e['code']){
    case 12514 : $msg_error="Base éteinte";break;
  }
  echo "Erreur de Connection à la Base : $msg_error<br><br>";
	echo "<form action = 'index.php' method='post' enctype='application/x-www-form-urlencoded'>
				<input type='submit' value='Retour'>
		  </form>";
	exit;
  }
  return $conn;
}
//---------------------------------------------------------------------------------------------
function PreparerRequete($conn,$req)
{
  $cur = oci_parse($conn, $req);
  
  if (!$cur) 
  {  
	$e = oci_error($conn);  
	print htmlentities($e['message']);  
	exit;
  }
  return $cur;
}
//---------------------------------------------------------------------------------------------
function ExecuterRequete($cur)
{
  $r = oci_execute($cur, OCI_DEFAULT);
  if (!$r) 
  {  
	$e = oci_error($r);  
	echo htmlentities($e['message']);  
	exit;
  }
  return $r;
}
//---------------------------------------------------------------------------------------------
function FermerConnexion($conn)
{
  oci_close($conn);
}
//---------------------------------------------------------------------------------------------
function LireDonnees1($cur,&$tab)
{
  $nbLignes = oci_fetch_all($cur, $tab,0,-1,OCI_ASSOC); //OCI_FETCHSTATEMENT_BY_ROW, OCI_ASSOC, OCI_NUM
  return $nbLignes;
}
//---------------------------------------------------------------------------------------------
function LireDonnees2($cur,&$tab)
{
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch_array ($cur, OCI_BOTH  )) 
  {    
    $tab[$nbLignes][$i]  = $row[0];
    $tab[$nbLignes][$i+1]  = $row[1];
    $tab[$nbLignes][$i+2]  = $row[2];
	$nbLignes++;
  }
  return $nbLignes;
}
function LireDonneesCoureur($cur,&$tab)
{
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch_array ($cur, OCI_BOTH  )) 
  {    
    $tab[$nbLignes][$i]  = $row[0];
    $tab[$nbLignes][$i+1]  = $row[1];
    $tab[$nbLignes][$i+2]  = $row[2];
    if(isset($row[3]))
      $tab[$nbLignes][$i+3]  = $row[3];
    else $tab[$nbLignes][$i+3] = "";
    $tab[$nbLignes][$i+4]  = $row[4];
    if(isset($row[5]))
      $tab[$nbLignes][$i+5]  = $row[5];
    else $tab[$nbLignes][$i+5] = "";
  $nbLignes++;
  }
  return $nbLignes;
}
function LireDonneesPays($cur,&$tab)
{
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch_array ($cur, OCI_BOTH  )) 
  {    
    $tab[$nbLignes][$i]  = $row['CODE_TDF'];
    $tab[$nbLignes][$i+1]  = $row['NOM'];
  $nbLignes++;
  }
  return $nbLignes;
}

<<<<<<< HEAD
function LireDonneesAnnee($cur,&$tab)
=======
function LireDonneesEpreuve($cur,&$tab)
>>>>>>> origin/master
{
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch_array ($cur, OCI_BOTH  )) 
  {    
<<<<<<< HEAD
    $tab[$nbLignes][$i]  = $row['ANNEE'];
    $tab[$nbLignes][$i+1]  = $row['JOUR_REPOS'];
=======
    $tab[$nbLignes][$i]  = $row[0];
    $tab[$nbLignes][$i+1]  = $row[1];
    $tab[$nbLignes][$i+2]  = $row[2];
    $tab[$nbLignes][$i+3]  = $row[3];
    $tab[$nbLignes][$i+4]  = $row[4];
    if(isset($row[5]))
    $tab[$nbLignes][$i+5]  = $row[5];
    else $tab[$nbLignes][$i+5] = "";
    $tab[$nbLignes][$i+6]  = $row[6];
    $tab[$nbLignes][$i+7]  = $row[7];
    $tab[$nbLignes][$i+8]  = $row[8];
    $tab[$nbLignes][$i+9]  = $row[9];
>>>>>>> origin/master
  $nbLignes++;
  }
  return $nbLignes;
}
<<<<<<< HEAD
=======

function LireDonneesAnnee($cur,&$tab){
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch_array ($cur, OCI_BOTH  )) 
  {
    $tab[$nbLignes][$i]  = $row[0];
    $tab[$nbLignes][$i+1]  = $row[1];
    $nbLignes++;
  }
}
>>>>>>> origin/master
//---------------------------------------------------------------------------------------------
function LireDonnees3($cur,&$tab)
{
  $nbLignes = 0;
  $i=0;
  while ($row = oci_fetch ($cur)) 
  {    
	$tab[$nbLignes][$i] = oci_result($cur,'VAL'); // respecter la casse
    $tab[$nbLignes][$i+1] = oci_result($cur,'TYPE');
	$tab[$nbLignes][$i+2] = oci_result($cur,'COULEUR');
	$nbLignes++;
  }
  return $nbLignes;
}
//---------------------------------------------------------------------------------------------
// fonctions autres
function AfficherDonnee1($tab,$nbLignes)
{
  if ($nbLignes > 0) 
  {
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    foreach ($tab as $key => $val)  // lecture des noms de colonnes
    {
      echo "<th>$key</th>\n";
    }
    echo "</tr>\n";
    for ($i = 0; $i < $nbLignes; $i++) // balayage de toutes les lignes
    {
      echo "<tr>\n";
      foreach ($tab as $data) // lecture des enregistrements de chaque colonne
	  {
        echo "<td>$data[$i]</td>\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  } 
  else 
  {
    echo "Pas de ligne<br />\n";
  } 
  echo "$nbLignes Lignes lues<br />\n";
}
//---------------------------------------------------------------------------------------------
function AfficherDonnee2($tab)
{
  foreach($tab as $ligne)
  {
    foreach($ligne as $valeur)
	  echo $valeur." ";
    echo "<br/>";
  }
}
//---------------------------------------------------------------------------------------------
function AfficherDonnee3($tab,$nb)
{
  for($i=0;$i<$nb;$i++)
    echo $tab[$i][0]." ".$tab[$i][1]." ".$tab[$i][2]."\n";
}
//---------------------------------------------------------------------------------------------

function ResultatRequete($conn,$req,&$tab){
  $cur = PreparerRequete($conn,$req);
  $res = ExecuterRequete($cur); // Attention, pas &$nbLignes
  $nbLignes = LireDonnees1($cur,$tab);
  return $nbLignes;
}
?>



