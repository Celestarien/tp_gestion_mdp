<?php
/*
	Supprime mot de passe
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

if(isset($_POST["submit_supp"]))
{
	$id=$_POST["id"];

	$requete="delete from passes where id=\"$id\"";
	$resultat=mysql_query($requete);
	if(!$resultat)
		$erreur.=mysql_error($connexion);
	else
		$suppression=1;
}

mysql_close($connexion);

?>

<html>
<head><title>Suppression d'un mot de passe</title>
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

<h2>Suppression d'un mot de passe</h2>

<?php
if($suppression==0)
{
?>
<div align="center" style="padding-top:30px;">
<form action="" method="post">
<input type="hidden" name="id" value="<?= $id ?>" />
<input type="submit" name="submit_supp" value="Oui" />
<input type="submit" name="submit_quit" value="Non" onclick="javascript:window.close();" />
</form>
</div>
<?php
}
else
{
?>
<div align="center" style="padding:40px;">
<b>Le mot de passe a bien �t� supprim� de la base</b><br /><br /><br />
<input type="button" value="Quitter" onclick="RefreshAndClose();" />
</div>
<?php
}
?>

<?php
if($erreur!="") echo "<div style=\"text-align:center;color:red;font-size:11px;border:1px dotted red;\">$erreur</div>";
?>

</html>