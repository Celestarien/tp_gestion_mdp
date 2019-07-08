<?php
/*
	Pour voir le mot de passe
*/

include("global.php");

$id=$_GET["id"];
$suppression=0;
$erreur="";

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

$requete="select pass from passes where id=\"$id\"";
$resultat=mysql_query($requete);
if(!$resultat)
	$erreur.=mysql_error($connexion);
else
{
	$objet=mysql_fetch_object($resultat);
	$pass=$objet->pass;
	//creation de l'image en fct du pass
	
}


mysql_close($connexion);


?>

<html>
<head><title>Voir le mot de passe</title>
<style type="text/css">
a, a:visited{
color:#0000CC;
}

a:hover{
color:#0000CC;
}
</style>
</head>

<h2>Voir le mot de passe</h2>

<div align="center" style="padding:40px;">
<img src="image_pass.php?id=<?= $id ?>" /><br /><br /><br />
<input type="button" value="Quitter" onclick="javascript:window.close();" />
</div>

<?php
if($erreur!="") echo "<div style=\"text-align:center;color:red;font-size:11px;border:1px dotted red;\">$erreur</div>";
?>

</html>