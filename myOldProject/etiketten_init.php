<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in etiketten_init.php");


header("Content-Type: text/html; charset=utf-8");

session_start();		//damit ich auf sess_regatta_id zugreifen kann und teilnehmer_id als session- Variable definieren kann...

//nur wenn der User der Administrator ist, darf diese Seite angezeigt werden!
If ($_SESSION['sess_login_rechte'] !="administrator")
{
Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
die;
}
?>
<html>
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<title>Etiketten-Ma&szlig;e einstellen</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; 		//Zeichencodierung definieren ?>

<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
<script src="/functions.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function checkForm()
{
        var errmsg="";
		
		if (document.etiketten_init.format.value == "")
        {
             errmsg="\n Bitte Etikettenformat (L für Querformat, P für Hochformat) eingeben";
             document.etiketten_init.format.focus();
             alert(errmsg);
             return false;
        }
		
        if (document.etiketten_init.Rl.value == "")
        {
                errmsg += "\n Bitte linken Seitenrand eingeben";
                document.etiketten_init.Rl.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Rr.value == "")
        {
                errmsg += "\n Bitte rechten Seitenrand eingeben";
                document.etiketten_init.Rr.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Ro.value == "")
        {
                errmsg += "\n Bitte oberen Seitenrand eingeben";
                document.etiketten_init.Ro.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Ru.value == "")
        {
                errmsg += "\n Bitte unteren Seitenrand eingeben";
                document.etiketten_init.Ru.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.etiketten_hoehe.value == "")
        {
                errmsg += "\n Bitte die Höhe des Etikettes eingeben";
                document.etiketten_init.etiketten_hoehe.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.etiketten_breite.value == "")
        {
                errmsg += "\n Bitte die Breite des Etikettes eingeben";
                document.etiketten_init.etiketten_breite.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.etiketten_in_zeile.value == "")
        {
                errmsg += "\n Bitte die Anzahl der Etikettesn in einer Zeile eingeben";
                document.etiketten_init.etiketten_in_zeile.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.etiketten_in_spalte.value == "")
        {
                errmsg += "\n Bitte die Anzahl der Etikettesn in einer Spalte eingeben";
                document.etiketten_init.etiketten_in_spalte.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.vertikalabstand.value == "")
        {
                errmsg += "\n Bitte den Vertikalabstand eingeben (das ist jener Abstand von der linken oberen Ecke einer Etikette zur linken oberen Ecke der darunterliegenden Etikette";
                document.etiketten_init.vertikalabstand.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.horizontalabstand.value == "")
        {
                errmsg += "\n Bitte den Horizontalabstand eingeben (das ist jener Abstand von der linken oberen Ecke einer Etikette zur linken oberen Ecke der rechts-daneben liegenden Etikette";
                document.etiketten_init.horizontalabstand.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Rl_in_der_etikette.value == "")
        {
                errmsg += "\n Bitte den linken Rand in der Etikette eingeben";
                document.etiketten_init.Rl_in_der_etikette.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Rr_in_der_etikette.value == "")
        {
                errmsg += "\n Bitte den rechten Rand in der Etikette eingeben";
                document.etiketten_init.Rr_in_der_etikette.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Ro_in_der_etikette.value == "")
        {
                errmsg += "\n Bitte den oberen Rand in der Etikette eingeben";
                document.etiketten_init.Ro_in_der_etikette.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.Ru_in_der_etikette.value == "")
        {
                errmsg += "\n Bitte den untren Rand in der Etikette eingeben";
                document.etiketten_init.Ru_in_der_etikette.focus();
                alert(errmsg);
                return false;
        }

        if (document.etiketten_init.zeilen_hoehe.value == "")
        {
                errmsg += "\n Bitte die Zeilenhöhe in der Etikette eingeben";
                document.etiketten_init.zeilen_hoehe.focus();
                alert(errmsg);
                return false;
        }


        return true;
}
/-->
</script>
</head>
<body>
<?php
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//******************************************
//******************************************
//wurde auf speichern geklickt?
if ($_POST['speichern']=="Speichern")
    {
    //Datensatz updaten

    //sql-Statement erstellen
    $sql="UPDATE tbl_etiketten ";
    $sql.="SET format='".$_POST['format']."',Rl='".$_POST['Rl']."', ";
	$sql.="Rr='".$_POST['Rr']."',Ro='".$_POST['Ro']."',Ru='".$_POST['Ru']."', ";
	$sql.="etiketten_hoehe='".$_POST['etiketten_hoehe']."',etiketten_breite='".$_POST['etiketten_breite']."',etiketten_in_zeile='".$_POST['etiketten_in_zeile']."', ";
	$sql.="etiketten_in_spalte='".$_POST['etiketten_in_spalte']."',vertikalabstand='".$_POST['vertikalabstand']."',horizontalabstand='".$_POST['horizontalabstand']."', ";
	$sql.="Rl_in_der_etikette='".$_POST['Rl_in_der_etikette']."',Rr_in_der_etikette='".$_POST['Rr_in_der_etikette']."', ";
	$sql.="Ro_in_der_etikette='".$_POST['Ro_in_der_etikette']."',Ru_in_der_etikette='".$_POST['Ru_in_der_etikette']."', ";
	$sql.="zeilen_hoehe='".$_POST['zeilen_hoehe']."' ";	
	$sql.="WHERE etiketten_nr=1";


	$statement = $mydb->prepare($sql);
	if($statement->execute()){}
    }
?>
<?php
//Etiketten-Maße mit der Etiketten_nr=1 selektieren (es gibt nur einen Datensatz und der hat etiketten_nr 1

//sql-Statement erstellen
$sql="SELECT etiketten_nr, format, Rl, Rr, Ro, Ru, etiketten_hoehe, etiketten_breite, etiketten_in_zeile, etiketten_in_spalte, ";
$sql.="vertikalabstand, horizontalabstand, Rl_in_der_etikette, Rr_in_der_etikette, Ro_in_der_etikette, Ru_in_der_etikette, zeilen_hoehe ";
$sql.="FROM tbl_etiketten ";
$sql.="WHERE etiketten_nr=1";
//echo $sql;


$statement = $mydb->prepare($sql);
if($statement->execute()){}

//es gibt nur einen Datensatz -> Daten ins Formular eintragen
while ($akt_zeile=$statement->fetch()) {    	
?>
<img src="bilder/datenbank-kopf.png" width="100%" height="auto" alt=""/> 	
<div id="content">

	
<table> 
	<tr>
		<td><h1>Etiketten-Maße einstellen</h1></td>
	</tr>
	<tr>
		<td><?php echo $_SESSION['sess_login_rechte'];?></td>
	</tr>
</table>
	
<form method="post" onSubmit="return checkForm()" action="<?php echo $PHP_SELF;?>" name="speichern">	
<div id=formular>	

<section class="formular-articles">
	<!------>
	<!-- jeweils 2 article-Blöcke bilden eine Zeile   ----->
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2"><strong>Maße in mm eingeben. Komma wird als "." eingegeben.</strong></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>P für Hoch- oder L für Querformat :</td>
			<td><input type="text" name="format" value="<?php echo $akt_zeile['format']; ?>"></td>
		  </tr>
		</table>
	</article>	
</section>	
	
<section>
	<article class="box formular">
	  <table>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</article>		
</section>
	
<section class="formular-articles">
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>linker Seitenrand:</td>
			<td><input type="text" name="Rl" value="<?php echo $akt_zeile['Rl']; ?>"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>rechter Seitenrand:</td>
			<td><input type="text" name="Rr" value="<?php echo $akt_zeile['Rr']; ?>"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>oberer Seitenrand:</td>
			<td><input type="text" name="Ro" value="<?php echo $akt_zeile['Ro']; ?>"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>unterer Seitenrand:</td>
			<td><input type="text" name="Ru" value="<?php echo $akt_zeile['Ru']; ?>"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Etiketten-Höhe:</td>
			<td><input type="text" name="etiketten_hoehe" value="<?php echo $akt_zeile['etiketten_hoehe']; ?>"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Etiketten-Breite:</td>
			<td><input type="text" name="etiketten_breite" value="<?php echo $akt_zeile['etiketten_breite']; ?>"></td>
		  </tr>
		</table>
	</article>		
</section>
	
<section>
	<article class="box formular">
	  <table>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</article>		
</section>

	
<section class="formular-articles">
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Anzahl der Etiketten in einer Zeile:</td>
			<td><input type="text" name="etiketten_in_zeile" value="<?php echo $akt_zeile['etiketten_in_zeile']; ?>"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Anzahl der Etiketten in einer Spalte:</td>
			<td><input type="text" name="etiketten_in_spalte" value="<?php echo $akt_zeile['etiketten_in_spalte']; ?>"></td>
		  </tr>
		</table>
	</article>		
</section>
	
	
<section>
	<article class="box formular">
	  <table>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</article>		
</section>	
	
<section class="formular-articles">
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Rand links in der Etikette:</td>
			<td><input type="text" name="Rl_in_der_etikette" value="<?php echo $akt_zeile['Rl_in_der_etikette']; ?>"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Rand rechts in der Etikette:</td>
			<td><input type="text" name="Rr_in_der_etikette" value="<?php echo $akt_zeile['Rr_in_der_etikette']; ?>"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Rand oben in der Etikette:</td>
			<td><input type="text" name="Ro_in_der_etikette" value="<?php echo $akt_zeile['Ro_in_der_etikette']; ?>"></td>
		  </tr>
		</table>
	</article>			
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Rand unten in der Etikette:</td>
			<td><input type="text" name="Ru_in_der_etikette" value="<?php echo $akt_zeile['Ru_in_der_etikette']; ?>"></td>
		  </tr>
		</table>
	</article>		
</section>
	
	
<section>
	<article class="box formular">
	  <table>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</article>		
</section>	
	
	
<section class="formular-articles">
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Zeilenhöhe in der Etikette:</td>
			<td><input type="text" name="zeilen_hoehe" value="<?php echo $akt_zeile['zeilen_hoehe']; ?>"></td>
		  </tr>
		</table>
	</article>	
</section>
	
	
<section>
	<article class="box formular">
	  <table>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</article>		
</section>		
	
	
	
<section class="formular-articles">
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				Vertikalabstand (Abstand von der linken oberen Ecke eines Etikettes bis zur linken oberen Ecke des darunter liegenden Etikettes:
		  	</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<input type="text" name="vertikalabstand" value="<?php echo $akt_zeile['vertikalabstand']; ?>">
			</td>
		  </tr>
		</table>
	</article>		
	
	
	
	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				Horizontalabstand (Abstand von der linken oberen Ecke eines Etikettes bis zur linken oberen Ecke des rechts-daneben liegenden Etikettes:
		  	</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<input type="text" name="horizontalabstand" value="<?php echo $akt_zeile['horizontalabstand']; ?>">
			</td>
		  </tr>
		</table>
	</article>		
</section>
	
</div> <!-- div id=formular-->
</div>   <!--  div id=content -->
<?php
}
?>	

	
<!-------------------------------------------------------------------------->
<!-- Beginn Navigationsbuttons --------------------------------------------->
<section class="navi-articles">
	<article class="box navi">
		<table align="center">	
			<tr>
				<td>
					<input type="submit" name="speichern" value="Speichern">
				</td>
			</tr>
		</table>
			</form>
	</article>	
	
	<article class="box navi">
		<table align="center">	
			<tr>
				<td>
					<form class="navi_hoehe" method="post" action="/regattaliste.php" name="regattaliste">
					<input type="submit" name="regattaliste" value="Regattaliste">
					</form>
				</td>
			</tr>
		</table>
	</article>	
	
</section>	
</body>
</html>