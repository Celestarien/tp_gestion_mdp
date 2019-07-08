<?php
/*
	Page de recherche des mots de passe
*/

include("global.php");

$nb_rech=0;
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

if(isset($_POST["submit_rech"]))
{
	$tab_rech=array();
	$requete="select * from passes where 1 ";
	
	if(isset($_POST["motscles"]) && $_POST["motscles"]!="")
	{
		$rech=$_POST["motscles"];
		$tab_mots=explode(" ",$rech);
		foreach($tab_mots as $mot)
		{
			$requete.=" and nom like \"%$mot%\" ";
		}
	}
	elseif(isset($_POST["adresse"]) && $_POST["adresse"]!="")
	{
		$rech=$_POST["adresse"];
		$tab_mots=explode(" ",$rech);
		foreach($tab_mots as $mot)
		{
			$requete.=" and adresse like \"%$mot%\" ";
		}
	}
	elseif(isset($_POST["login"]) && $_POST["login"]!="")
	{
		echo "la";
		$rech=$_POST["login"];
		$tab_mots=explode(" ",$rech);
		foreach($tab_mots as $mot)
		{
			$requete.=" and login like \"%$mot%\" ";
		}
	}
	else
		$erreur.="Erreur un ou plusieurs champs sont vides<br />";
		
	if($erreur=="")
	{
		//ececute la recherche
		$resultat=mysql_query($requete,$connexion);
		while($ligne=mysql_fetch_assoc($resultat))
		{
			$nb_rech++;
			$tab_rech[]=$ligne;
		}

		//image du pass
		$img_pass="";
		for($i=0;$i<5;$i++)
		{
			$img_pass.="<img src=\"rond.gif\" />&nbsp;";
		}
	}
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

<?php
if($nb_rech==0)
{
?>
<b>Menu:</b>
<div style="padding-bottom:40px;">
<a href="pass.php">Retour � l'acceuil</a>
</div>

<table>
<form name="rech" action="recherche.php" method="post">
<tr>
<td>Rechercher par mots cl�s:</td>
<td><input type="text" name="motscles" size="25" value="" />
</tr>
<tr>
<td>Rechercher par adresse web:
<td><input type="text" name="adresse" size="25" value="" />
</tr>
<tr>
<td>Rechercher par login:
<td><input type="text" name="login" size="25" value="" />
</tr>
<tr>
<td colspan="2" align="right"><input type="submit" name="submit_rech" value="Go" />
<tr>
</form>
</table>
<?php
}
else
{
?>
<b>Menu:</b>
<div style="padding-bottom:40px;">
<a href="pass.php">Retour � l'acceuil</a> - 
<a href="recherche.php">Nouvelle recherche</a>
</div>

<div>
<b><?= $nb_rech ?></b> r�sultats trouv�s dans la base.
</div>

<table border="1" cellpadding="10" style="border-collapse:collapse;">
<th>No</th><th>Nom</th><th>Adresse</th><th>Login</th><th>Mot de passe</th><th width="120px">Commande</th>
<?php
for($i=0;$i<$nb_rech;$i++)
{
	$id=$tab_rech[$i]["id"];
	$nom=$tab_rech[$i]["nom"];
	$adresse=$tab_rech[$i]["adresse"];
	$login=$tab_rech[$i]["login"];
	$pass=$tab_rech[$i]["pass"];
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
<?php
}
?>

</body>

</html>