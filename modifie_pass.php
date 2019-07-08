<?php
/*
	Modifie le mot de passe
*/

include("global.php");

$id=$_GET["id"];
$erreur="";
$modification=0;

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

if(isset($_POST["submit_modif"]))
{
	$id=$_POST["id"];
	$nom=$_POST["nom"];
	$adresse=$_POST["adresse"];
	$login=$_POST["login"];
	$pass=$_POST["pass"];
	
	if($nom=="" || $adresse=="" || $login=="" || $pass=="") 
		$erreur.="ERREUR: Un ou plusieurs champs sont vides <br />";
	else
	{
		$requete="update passes set nom=\"$nom\",adresse=\"$adresse\",login=\"$login\",pass=\"$pass\" where id=\"$id\"";
		$resultat=mysql_query($requete);
		if(!$resultat)
			$erreur.=mysql_error($connexion);
		else
			$modification=1;
	}
}
else
{
	//recuperation des infos
	$requete="select nom,adresse,login from passes where id=\"$id\"";
	$resultat=mysql_query($requete);
	$objet=mysql_fetch_object($resultat);
	$nom=$objet->nom;
	$adresse=$objet->adresse;
	$login=$objet->login;
}

mysql_close($connexion);

?>

<html>
<head><title>Modifier le mot de passe</title>
<style type="text/css">
a, a:visited{
color:#0000CC;
}

a:hover{
color:#0000CC;
}
</style>
<script language="JavaScript" type="text/javascript">
<!-- Rafra�chir le contenu et fermer
function RefreshAndClose() {
	if (!window.opener.closed) {
	   opener.location = opener.location;
	   parent.close();
	}
}
// -->
</script>
</head>

<h2>Modification d'un mot de passe</h2>

<?php
if($modification==0)
{
?>
<form action="" method="post">
<table>
<tr><td>Nom: </td><td><input type="text" value="<?= $nom ?>" name="nom" size="35" /></td></tr>
<tr><td>adresse: </td><td><input type="text" value="<?= $adresse ?>" name="adresse" size="35" /></td></tr>
<tr><td>Login: </td><td><input type="text" value="<?= $login ?>" name="login" size="35" /></td></tr>
<tr><td>Mot de passe: </td><td><input type="password" value="" name="pass" size="35" /></td></tr>
<tr><td colspan="2" align="center" style="padding-top:15px;">
<input type="hidden" name="id" value="<?= $id ?>" />
<input type="submit" name="submit_modif" value="Modifier" />
<input type="submit" name="submit_quit" value="Quitter" onclick="javascript:window.close();" />
</td></tr>
</table>
</form>
<?php
}
else
{
?>
<div align="center" style="padding:40px;">
<b>Les informations ont bien �t� modifi�es</b><br /><br /><br />
<input type="button" value="Quitter" onclick="RefreshAndClose();" />
</div>
<?php
}
?>


<?php
if($erreur!="") echo "<div style=\"text-align:center;color:red;font-size:11px;border:1px dotted red;\">$erreur</div>";
?>

</html>