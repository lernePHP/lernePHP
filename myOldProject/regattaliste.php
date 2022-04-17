<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
//debug_to_console("Hallo in regattaliste");		//Achtung! Funktioniert nur, 
													//wenn die Header-Anweisungen auskommentiert werden!

header("Content-Type: text/html; charset=utf-8");

session_start();

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

if (!isset($_SESSION['sess_login_rechte']) || $_SESSION['sess_login_rechte']!="administrator")
{
   
    $seite = "index.php";
    header("Location: http://$host$uri/$seite");
	die;
}
		
//hier wird nur verzweigt, wenn sich der Administrator eingeloggt hat. Nur dann darf die regattaliste angezeigt werden.
//Session-Variablen definieren und initialisieren

//Achtung: table width sollte eigentlich 1000 sein, damit kein Rollbalken erscheint. Um "L�schen" zu verstecken, habe ich es ganz nach rechts gestellt, so dass man scrollen muss. Das ist eine Übergangslösung. Nachher tablewidth wieder auf 1000 setzen!
$_SESSION['sess_regatta_id']="";
$_SESSION['sess_teilnehmer_id']="";
$_SESSION['sess_crewmitglied_id']="";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<title>Verwalten von Regatten</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>

	
<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
</head>
<body>

<div id="content">
	
<img src="bilder/datenbank-kopf.png" width="100%" height="auto" alt=""/> 	

	
<table cellpadding="7" cellspacing="0">

        <tr><td><h1>Verwalten von Regatten</h1></td></tr>
		<tr><td><?php echo $_SESSION['sess_login_rechte'];?></td></tr>
</table>
	
	
<table class="breite_liste">
<?php
//laufende Durchnumerierung der Regatten
$nr=1;

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';


//sql-Statement erstellen
$sql="SELECT regatta_id,Regatta_Name FROM tbl_regatta  ORDER BY  `Regatta_Beginn` DESC";
//echo $sql;

$statement = $mydb->prepare($sql);
																							   
if ($statement->execute()){
	foreach ($mydb->query($sql) as $akt_zeile)
		   {
		   //laufende Nummer, Regatta-Name und die zwei Links / Buttons in die Tabelle eintragen
		   echo "<tr>";
				  echo "<td>".$nr."</td>";
				  echo "<td>".$akt_zeile["Regatta_Name"]."</td>";
				  echo "<td><a href='/regatta_admin.php?regatta_id=".$akt_zeile["regatta_id"]."'>Verwalten</a></td>";
				  echo "<td><a href='/teilnehmerliste.php?regatta_id=".$akt_zeile["regatta_id"]."'>Teilnehmerliste und Meldung neuer Teilnehmer</a></td>";
				  echo "<td><a href='/gruppenliste.php?regatta_id=".$akt_zeile["regatta_id"]."'>Gruppenliste</a></td>";
				  echo "<td><a href='/crewliste_pdf_alle_boote.php?regatta_id=".$akt_zeile["regatta_id"]."'>Crewliste / PDF alle Boote</a></td>";
				  echo "<td><a href='/registrierungsblatt_alle_boote.php?regatta_id=".$akt_zeile["regatta_id"]."'>Registrierungsblatt / PDF alle Boote</a></td>";	
				  echo "<td><a href='/etiketten_alle_boote.php?regatta_id=".$akt_zeile["regatta_id"]."'>Etiketten</a></td>";			  
				  echo "<td><a href='/teilnehmer_export.php?regatta_id=".$akt_zeile["regatta_id"]."'>Teilnehmer-Export</a></td>";	
				  echo "<td><a href='/kontroll_listen_seite.php?regatta_id=".$akt_zeile["regatta_id"]."'>Kontroll-Listen</a></td>";	

				  echo "<td><a href='/zertifikate_fuer_eine_regatta_erstellen.php?regatta_id=".$akt_zeile["regatta_id"]."'>Zertifikate drucken</a></td>";	
				  echo "<td><a href='/TN_Export_als_excel.php?regatta_id=".$akt_zeile["regatta_id"]."'>Teilnehmer-Export für Regattaprogramm</a></td>";	
				  echo "<td><a href='/regatta_del_question.php?regatta_id=".$akt_zeile["regatta_id"]."'>Löschen</a></td>";


			  echo "</tr>";
			  echo "<tr><td>&nbsp;&nbsp;&nbsp;</td></tr>";			  
		   //lfd. Nr erhöhen
		   $nr++;
		   }
}

?>
</table>
</div>   <!--  div id=content -->
	
<!-------------------------------------------------------------------------->
<!-- Beginn Navigationsbuttons --------------------------------------------->

<section class="navi-articles">
	<article class="box navi">
		<table align="center">
		<tr>		
			<form action="/regatta_eingabe.php" method="post">
			<td><input type="submit" name="reg_neu" value="Neue Regatta"></td>
			</form>
		</tr>
		</table>
	</article>
	
	<article class="box navi">
		<table align="center">
		<tr>		
			<form action="/etiketten_init.php" method="post">
       		<td><input type="submit" name="etiketten_init" value="Etiketten-Maße"></td>
       		</form>
		</tr>
		</table>
	</article>
	
	<article class="box navi">
	</article>	
	
	<article class="box navi">
		<table align="center">
		<tr>		
			<form action="/cgi-bin/crondump.pl?config=mysqldumper" method="post">
       		<td><input type="submit" name="Sichern Start" value="Sicherung Start"></td>
       		</form>
		</tr>
		</table>
	</article>
	
	<article class="box navi">
		<table align="center">
		<tr>		
			<form action="/msd1.24.4/filemanagement.php?action=restore" method="post">
       		<td><input type="submit" name="Sichern restore" value="Sicherung restore"></td>
       		</form>
		</tr>
		</table>
	</article>	
</section>

	
</body>
</html>