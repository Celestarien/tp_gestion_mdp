<?php
/*
	Page de sauvegarde des mots de passe
*/

include("global.php");

//connexion au serveur
$connexion=mysql_pconnect(SERVEUR,LOGIN,PASS);
$tri="nom";
$up=1;

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

//recuperation du tri
if(isset($_GET["tri"]))
{
	$tri_tmp=$_GET["tri"];
	$tab_tri=array("nom","adresse","login");
	$tab_up=array("0","1");
	if(in_array($tri_tmp,$tab_tri))
	{
		if(isset($_GET["up"]) && in_array($_GET["up"],$tab_up))
		{
			$tri=$tri_tmp;
			$up=$_GET["up"];
		}
		else
			$up=1;
	}
	else
		$tri="nom";
}

//recuperation des infos dans la base
$desc=($up==0)?"desc":"";
$requete="select * from passes order by $tri $desc";
$resultat=mysql_query($requete);
$nb_infos=0;
while($ligne=mysql_fetch_assoc($resultat))
{
	$nb_infos++;
	//$ligne["pass"]=ereg_replace(".","*",$ligne["pass"]);
	$tab_infos[]=$ligne;
}

//image du pass
$img_pass="";
for($i=0;$i<5;$i++)
{
	$img_pass.="<img src=\"rond.gif\" />&nbsp;";
}

//ferme la connexion
mysql_close($connexion);

?>

<html>
<head>
<title>title</title>
<style type="text/css">
body{
margin:10px;
font-size:12px;
font-family: Arial, Helvetica, sans-serif;
}

a, a:visited{
color:#0000CC;
}

a:hover{
color:#0000CC;
}

table{
font-size:12px;
}
</style>
</head>

<body>

<table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse:">
<tr>
<td valign="top">
<b>Menu:</b>
<div style="padding-bottom:40px;">
<a href="" onclick="javascript:window.open('ajout_pass.php','pass','width=400,height=250,scrollbars=yes');">Ajouter un mot de passe</a> - 
<a href="recherche.php">Recherche avan��e</a>
</div>
</td>
<td valign="top" align="right">
<form name="rech" action="recherche.php" method="post">
Rechercher:
<input type="text" name="motscles" size="25" value="" />
<input type="submit" name="submit_rech" value="Go" />
</form>
</td>
</table>

<div>
<b><?= $nb_infos ?></b> mots de passe enregistr�s dans la base.
</div>

<table border="1" cellpadding="10" style="border-collapse:collapse;">
<th>No</th>
<th><a href="?tri=nom&up=<?= ($tri=="nom")?(($up+1)%2):1 ?>">Nom</a>
<?= ($tri=="nom")?(($up==0)?"<img src=\"sort-down.gif\" />":"<img src=\"sort-up.gif\" />"):"" ?>
</th>
<th><a href="?tri=adresse&up=<?= ($tri=="adresse")?(($up+1)%2):1 ?>">Adresse</a>
<?= ($tri=="adresse")?(($up==0)?"<img src=\"sort-down.gif\" />":"<img src=\"sort-up.gif\" />"):"" ?>
</th>
<th><a href="?tri=login&up=<?= ($tri=="login")?(($up+1)%2):1 ?>">Login</a>
<?= ($tri=="login")?(($up==0)?"<img src=\"sort-down.gif\" />":"<img src=\"sort-up.gif\" />"):"" ?>
</th>
<th>Mot de passe</th>
<th width="120px;">Commande</th>
<?php
for($i=0;$i<$nb_infos;$i++)
{
	$id=$tab_infos[$i]["id"];
	$nom=$tab_infos[$i]["nom"];
	$adresse=$tab_infos[$i]["adresse"];
	$login=$tab_infos[$i]["login"];
	$pass=$tab_infos[$i]["pass"];
	echo "<tr>";
	echo "<td>$i</td><td>$nom</td>";
	if($adresse=="-") echo "<td>-</td>";
	else echo "<td><a target=\"_blank\" href=\"$adresse\">$adresse</a></td>";
	echo "<td>$login</td><td align=\"center\">";
	echo "<a href=\"#\" onclick=\"javascript:window.open('voir_pass.php?id=$id','pass','width=400,height=250,scrollbars=yes');\">Voir</a>";
	echo "</td>";
	echo "<td>";
	echo "<a href=\"\" onclick=\"javascript:window.open('supprime_pass.php?id=$id','pass','width=400,height=150,scrollbars=yes');\">Supprimer</a> - ";
	echo "<a href=\"\" onclick=\"javascript:window.open('modifie_pass.php?id=$id','pass','width=400,height=250,scrollbars=yes');\">Modifier</a></td>";
	echo "</tr>";
}
?>
</table>

</body>

</html>