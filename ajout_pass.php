<?php
/*
	Ajout de mot de passe
*/

include("global.php");

$nom="";
$adresse="";
$login="";
$pass="";
$erreur="";
$ajout=0;

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
	$nom=$_POST["nom"];
	$adresse=$_POST["adresse"];
	$login=$_POST["login"];
	$pass=$_POST["pass"];
	
	if($nom=="" || $adresse=="" || $login=="" || $pass=="") 
		$erreur.="ERREUR: Un ou plusieurs champs sont vides <br />";
	else
	{
		$requete="insert into passes values(\"\",\"$nom\",\"$adresse\",\"$login\",\"$pass\")";
		$resultat=mysql_query($requete);
		if(!$resultat)
			$erreur.=mysql_error($connexion);
		else
			$ajout=1;
	}
}

mysql_close($connexion);

?>

<html>
<head><title>Nouveau mot de passe</title>
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

<h2>Ajout d'un mot de passe</h2>

<?php
if($ajout==0)
{
?>
<form action="" method="post">
<table>
<tr><td>Nom: </td><td><input type="text" value="<?= $nom ?>" name="nom" size="35" /></td></tr>
<tr><td>adresse: </td><td><input type="text" value="<?= $adresse ?>" name="adresse" size="35" /></td></tr>
<tr><td>Login: </td><td><input type="text" value="<?= $login ?>" name="login" size="35" /></td></tr>
<tr><td>Mot de passe: </td><td><input type="password" value="<?= $pass ?>" name="pass" size="35" /></td></tr>
<tr><td colspan="2" align="center" style="padding-top:15px;">
<input type="submit" name="submit_modif" value="Enregistrer" />
<input type="submit" name="submit_quit" value="Quitter" onclick="javascript:window.close();" />
</td></tr>
</table>
</form>
<?php
}
else
{
?>
<div style="padding:40px;">
<a href="" onclick="RefreshAndClose();">Quitter</a> - 
<a href="ajout_pass.php">Ajouter un nouveau mot de passe</a>
</div>
<?php
}
?>


<?php
if($erreur!="") echo "<div style=\"text-align:center;color:red;font-size:11px;border:1px dotted red;\">$erreur</div>";
?>

</html>