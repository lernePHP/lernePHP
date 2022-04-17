<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crewliste_pdf_alle_boote.php");

// regatta_id muss beim Aufruf übergeben werden als $_GET
$nur_einer=0;		//es sollen die Crewlisten aller Boote gedruckt werden

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

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//sql-Statement erstellen
$sql_TN="SELECT teilnehmer_id,regatta_fid,nachname,vorname FROM tbl_teilnehmer_boot ";
$sql_TN.="WHERE (regatta_fid=".$_SESSION['sess_regatta_id'].") ORDER BY nachname,vorname";
	
$statement_TN = $mydb -> prepare($sql_TN);
if ($statement_TN->execute()) {}

if ($statement_TN->rowCount()==0) {
	//noch keine Teilnehmer gespeichert
	echo "<html><head><head><body>Es sind noch keine Boote gemeldet!</body></html>";
}		
else {
	debug_to_console("es gibt Teilnehmer -> else-Zweig");
	//PDF Dokument erstellen und Dokumentvariablen initialisieren
	include $_SERVER['DOCUMENT_ROOT'].'/crewliste_pdf_doc_erstellen.php';
		
	//es sind schon Teilnehmer gemeldet, Crewliste als PDF aufbauen
	while ($akt_zeile_TN=$statement_TN->fetch())
		   {
		   $teilnehmer_id=$akt_zeile_TN["teilnehmer_id"];
		   include $_SERVER['DOCUMENT_ROOT'].'/crewliste_pdf.php';
		   //echo "<br>teilnehmer: ".$teilnehmer_id;
		   }
}
//$pdf -> output();	
$pdf -> output("Crewliste aller Boote.pdf","I");	
?>
