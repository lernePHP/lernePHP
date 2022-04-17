<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crewliste_lesen.php");




header("Content-Type: text/html; charset=utf-8");

//$teilnehmer_id wird übergeben
//wenn keine id (sprich teilnehmer)übergeben wurde, dann "stirb"
if (!$_GET['teilnehmer_id']) die;
$teilnehmer_id=$_GET['teilnehmer_id'];  //wird gebraucht vor dem include von teilnehmer_suchen2.php
session_start();

$sprache = $_SESSION['sprache'];
if ($sprache == "deutsch") {
	//Variablen;
	$title = "Crewmitglieder";
	$crewliste = "Crewliste";
	$teilnehmerliste ="Zur&uuml;ck zur Meldeliste";
}
else {
	//Variablen
	$title = "Members of the Crew";
	$crewliste = "List of crew members";
	$teilnehmerliste ="Back to the Entry List";
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<title><?php echo $title;?></title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php';?>

<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">

	
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php';?>
<div id="content">
<?php
//Überschriften-Kopf einfügen
//dabei ist es wichtig, dass $sess_teilnehmer_id an dieser Stelle feststeht.
//Das ist der Fall, denn teilnehmer_id wird beim Aufruf von crewliste.php übergeben.

include $_SERVER['DOCUMENT_ROOT'].'/seitenkopf_schreiben_crew.php';

//in seitenkopf_schreiben.php wird eine Tabelle mit den Kopf-Informationen angelegt.
//diese Tabelle fungiert als "Stand-Alone"-Lösung für den Seitenkopf.
//Weitere Daten können in eine weitere Tabelle dahinter eingefügt werden.
?>

<table  cellpadding="7" cellspacing="0">
<?php
//laufende Durchnumerierung der Crewmitglieder
$nr=2;		//die Durchnummerierung der Crewmitglieder beginnt mit 2, da Nr. 1 der Skipper ist.

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//teilnehmer_suchen.php includieren. in dieser Datei wird definiert:
//regatta_id und andere Teilnehmer-Dateien (Uns gehts hier um regatta_id)
//wichtig: zuvor muss teilnehmer_id feststehen; das ist hier der Fall: wird  übergeben.
include $_SERVER['DOCUMENT_ROOT'].'/teilnehmer_suchen.php';

//sql-Statement erstellen
//teilnehmer_id wird übergeben
$sql="SELECT crewmitglied_id,teilnehmer_fid,nachname,vorname FROM tbl_crewmitglied ";
$sql.="WHERE (teilnehmer_fid=".$_GET['teilnehmer_id'].")";
	
$statement = $mydb -> prepare($sql);
if ($statement->execute()) {}

if (($statement->rowCount())==0)
{
	//noch keine Crewmitglieder gespeichert
	echo "<tr><td>Es sind noch keine Crewmitglieder eingetragen!</td></tr>";
}		
else
{	
	
	//Überschrift "Skipper"
	echo "<tr>";
	echo "<td colspan='2'>";
	echo "<h3>Skipper</h3>";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	
		echo "<td>";
		echo "1";
		echo "</td>";
		
		echo "<td>";
		echo $skipper_name;
		echo "</td>";
		echo "<td>&nbsp;</td>";                    

	echo "</tr>";
	
	
	//es sind schon Crewmitglieder eingetragen, Crewliste aufbauen
	//Überschrift "Crewliste"
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr>";
	echo "<td colspan='2'>";
	echo "<h3>".$crewliste."</h3>";
	echo "</td>";
	echo "</tr>";
	while ($akt_zeile=$statement->fetch())
		   {
		   //laufende Nummer, Crew-Name in die Tabelle eintragen
		   echo "<tr>";
				echo "<td>".$nr."</td>";
				echo "<td align='left'>".$akt_zeile["vorname"]." ".$akt_zeile["nachname"]."</td>";
		   echo "</tr>";
		   //lfd. Nr erhöhen
		   $nr++;
		   }
}	
	
debug_to_console("Ende crewliste_lesen.php");	
?>

</table>
</div>
	

	
	
	
<section class="navi-articles">

	<article class="box navi">
      <table align="center"><tr><td>
		  <a href="/teilnehmerliste_lesen.php?regatta_id=<?php echo $_SESSION['sess_regatta_id'];?>"><?php echo $teilnehmerliste; ?></a>
		  </td></tr></table>
    </article>
	
</section>
	
</body>
</html>