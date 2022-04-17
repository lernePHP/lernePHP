<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in teilnehmerliste.php");

header("Content-Type: text/html; charset=utf-8");

//hierher darf nur der Administrator!
session_start();
if ($_SESSION['sess_login_rechte']!="administrator")
{
	Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
}

//Session-Variable für regatta_id definieren

//wenn keine id (sprich Regatta-ID)übergeben wurde, dann "stirb"
if (!$_GET['regatta_id']) die;

$_SESSION['sess_regatta_id']=$_GET['regatta_id'];

//sess_teilnehmer_id und sess_crewmitglied_id initialisieren
$_SESSION['sess_login_teilnehmer_id']="";
$_SESSION['sess_crewmitglied_id']="";

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">		
<title>Verwalten von Teilnehmern</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>

<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php'; ?>

<div id="content">
<table border="1" bordercolor="#003366" cellpadding="5" cellspacing="0" style="background-color: #FFFFFF;">     
        <tr><td colspan="8" align="left"><h1>Verwalten von Teilnehmern</h1></td></tr>
<?php
//laufende Durchnumerierung der Teilnehmer
$nr=1;

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

	
//sql-Statement erstellen
$sql="SELECT teilnehmer_id,regatta_fid,nachname,vorname FROM tbl_teilnehmer_boot ";
$sql.="WHERE (regatta_fid=".$_SESSION['sess_regatta_id'].") ORDER BY nachname,vorname";

	
$statement = $mydb -> prepare($sql);
if ($statement->execute())	{}
	
if ($statement->rowCount()==0)
{
	//noch keine Teilnehmer gespeichert
	echo "<tr><td>Es sind noch keine Boote gemeldet!</td></tr>";
}		
else
{	
	//es sind schon Teilnehmer gemeldet, Teilnehmerliste aufbauen
	while ($akt_zeile=$statement->fetch())
		   {
		   //laufende Nummer, Teilnehmer-Name und die zwei Links / Buttons in die Tabelle eintragen
		   echo "<tr>";
			echo "<td>".$nr."</td>";
			echo "<td>".$akt_zeile["nachname"]." ".$akt_zeile["vorname"]."</td>";
			echo "<td><a href='/teilnehmer_admin_administrator.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]."&erst_aufruf=1'>Verwalten</a></td>";
			echo "<td><a href='/crewliste.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]."'>Crewmitglieder ...</a></td>";				  
			echo "<td><a href='/teilnehmer_del_question.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]."'>Löschen</a></td>";
			echo "<td><a href='/zugangsdaten.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]."'>Zugangsdaten</a></td>";
			echo "<td><a href='/crewliste_pdf_aufruf.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]." & nur_einer=1'>Crewliste als PDF</a></td>";
			echo "<td><a href='/registrierungsblatt_aufruf.php?teilnehmer_id=".$akt_zeile["teilnehmer_id"]." & nur_einer=1'>Registrierungsblatt als PDF</a></td>";

			echo "</tr>";
				  
		   //lfd. Nr erhöhen
		   $nr++;
		   }
}	

debug_to_console("Ende teilnehmerliste.php");	
?>
</table>
</div>   <!-- id=content -->



<section class="navi-articles">

	<article class="box navi">
  		<table align="center">
		  <tr>
		  	<td>
		  	<a href="/teilnehmer_eingabe_administrator.php?regatta_id=<?php echo $_GET['regatta_id'];?>">Neuer Teilnehmer</a>
			</td>
		  </tr>
		</table>
    </article>

	
    <article class="box navi">
          <table align="center"><tr><td>
    	  <a href="/regattaliste.php">Regattaliste...</a>   
          </td></tr></table>
	</article>
	
	
    <article class="box navi">
          <table align="center"><tr><td>
    	  <a href="/meldeliste_nach_gruppen_auswahl.php">Anzeige der Meldeliste nach Gruppen</a>   
          </td></tr></table>
	</article>
						
</section>	

</body>
</html>