<?php

/*
	Genere l'image du mot de passe
*/

include("global.php");

//connexion au serveur
$connexion=mysql_pconnect(SERVEUR,LOGIN,PASS);

if(!$connexion)
{
	echo "Connexion au serveur ".SERVEUR." impossible\n";
	exit;
}

// Connexion a la base
if(!mysql_select_db(BASE, $connexion))
{
	echo "Acc�s � la base ".BASE." impossible\n";
	echo "<b>Message de MySQL: </b> ".mysql_error($connexion);
	exit;
}

//recupere le pass
$id=$_GET["id"];

$requete="select pass from passes where id=\"$id\"";
$resultat=mysql_query($requete);
if(!$resultat)
	exit();
else
{
	$objet=mysql_fetch_object($resultat);
	$pass=$objet->pass;
}

mysql_close($connexion);

// nouvelle image 100*30
$im = imagecreatetruecolor(300, 30);
// fond blanc et texte bleu
$bg = imagecolorallocate($im, 0, 0, 255);
$textcolor = imagecolorallocate($im, 255, 0, 255);
// ajout de la phrase en haut � gauche
imagestring($im, 5, 2, 5, $pass, $textcolor);
// affichage de l'image
header("Content-type: image/jpeg");
imagegif($im);
?> 