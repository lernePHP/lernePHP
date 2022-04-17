<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in etiketten_alle_boote.php");


$seiten_zaehler=0;
$zeilen_zaehler=0;
$spalten_zaehler=0;

// regatta_id muss beim Aufruf übergeben werden als $_GET

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

$statement_TN = $mydb->prepare($sql_TN);
if($statement_TN->execute()){}

if ($statement_TN->rowCount()==0) {
	//noch keine Teilnehmer gespeichert
	echo "<html><head><head><body>Es sind noch keine Boote gemeldet!</body></html>";
}		
else {
	//PDF Dokument erstellen und Dokumentvariablen initialisieren
	include $_SERVER['DOCUMENT_ROOT'].'/etiketten_pdf_doc_erstellen.php';
	
	$pdf -> AddPage();
	$zeilen_zaehler=1;
	$spalten_zaehler=1;
	$seiten_zaehler++;
	
	//x und y-Koordinaten für etiketten_pdf initialisieren
	$x=$Rl;
	$y=$Ro;
	
	//ich gehe spaltenweise vor. D.h. ich durcke zuerst alle 7 Etiketten der ersten Spalte, dann alle 7 der zweiten Spalte, 
	//danach alle 7 der dritten Spalte und dann erzeuge ich eine neue Seite mit neuen Spalten- und Zeilenzählern udn das
	//Spiel beginnt von vorne
	
	//es sind schon Teilnehmer gemeldet, Etiketten als PDF aufbauen
	while ($akt_zeile_TN=$statement_TN->fetch()) {
		   //wenn hierhergegangen wird, haben Spalten- und Zeilenzähler die aktuelle Nummer
		   //$x und $y stehen auf den neuen Koordinaten für die zu druckende Etikette
		   //neue Seite beginnen?
		   
		   $teilnehmer_id=$akt_zeile_TN["teilnehmer_id"];
		   
		   //echo "<br>zeilenzaehler: ".$zeilen_zaehler;
		   //echo "<br>spaltenzaehler: ".$spalten_zaehler;
		   //echo "<br>x: ".$x;
		   //echo "<br>y: ".$y;
		   //echo "<br>etiketten in spalte: ".$etiketten_in_spalte;

		   include $_SERVER['DOCUMENT_ROOT'].'/etiketten_pdf.php';
			
		   if ($zeilen_zaehler == $etiketten_in_spalte) {
		   //neue spalte beginnen bzw. wenn letzte Spalte schon gedruckt, neue Zeile beginnen
		   		if ($spalten_zaehler == $etiketten_in_zeile) {
					//neue Seite
					$pdf -> Addpage();
					$x=$Rl;
					$y=$Ro;	
					$zeilen_zaehler=1;
					$spalten_zaehler=1;
				}
				else {
					//neue Spalte
					$x=$x+$horizontalabstand;
					$y=$Ro;
					$spalten_zaehler++;
					$zeilen_zaehler=1;
				}
		   }
		   else {	 		   
		   		//zeilen, spaltenzähler ändern, x/y-Koordinaten ändern?
		   		$y=$y + $vertikalabstand;
		   		$zeilen_zaehler++;
		   }	
	}
}
$pdf -> output("Etiketten.pdf","I");

//debug_to_console("Ende etiketten_alle_boote.php");
?>
