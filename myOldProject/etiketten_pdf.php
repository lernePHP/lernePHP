<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enth�lt allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf daf�r w�re:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in etiketten_pdf.php");


//***************************************************************************************************
//Eingabe: $teilnehmer_id, $x, $y m�ssen als Variablen in der aufrufenden Datei festgelegt werden
// Include von etiketten_pdf_doc_erstellen, um ein PDF-Dokument zu estellen und die Dokument-Eigenschaften
// zu initialisieren
//Ausgabe: etikett als pdf
//***************************************************************************************************
//echo "teilnehmer: ".$teilnehmer_id;

//******************************** Skipper-Daten verf�gbar machen *****************************************
include $_SERVER['DOCUMENT_ROOT'].'/teilnehmer_suchen.php';		//ab hier sind die skipper- und Boots-Daten verf�gbar
										//Voraussetzung: $teilnehmer_id muss gesetzt sein
										//sessen_start() und connection.php wird hier aufgerufen

$TN_passnr=$passnr;		//muss ich mir merken, weil die $passnr dazwischen einmal auf "Passnummer" ge�ndert wird
//********************************* regatta_id und danach Veranstaltungsdaten ermitteln **********************
//$_SESSION['sess_regatta_id'] wird in teilnehmer_suchen.php gesetzt
$regatta_id=$_SESSION['sess_regatta_id'];
include $_SERVER['DOCUMENT_ROOT'].'/regatta_suchen.php';			//danach ist $regatta_name verf�gbar

//*******************************************************

$pdf -> SetFont($font, "", $font_size);

$nachname=$skipper_nachname;
$vorname=$skipper_vorname;

//$shirt_string ermitteln: ein String, der angibt, wieviele Shirts von welcher Gr��e das Boot ben�tigt:
//die Angaben kommen aus anzahl_S.php

$shirt_string="";
//f�r das Include von anzahl_S.php muss $shirt auf den Namen der Gr��e gesetzt werden
$shirt="Damen S";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." DS, ";

$shirt="Damen M";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." DM, ";

$shirt="Damen L";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." DL, ";

$shirt="Damen XL";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." DXL, ";

$shirt="Damen XXL";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." DXXL, \n";

//**************************
$shirt="Herren S";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." HS, ";

$shirt="Herren M";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." HM, ";

$shirt="Herren L";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." HL, ";

$shirt="Herren XL";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." HXL, ";

$shirt="Herren XXL";
include $_SERVER['DOCUMENT_ROOT'].'/anzahl_S.php';
$shirt_string .=$anzahl_shirt." HXXL";


$pdf -> SetXY($x,$y);


$pdf -> Cell($etiketten_breite_beschreibbar,$zeilen_hoehe,utf8_decode($skipper_vorname)." ".utf8_decode($skipper_nachname),0,2);

$pdf -> Cell($etiketten_breite_beschreibbar,$zeilen_hoehe,utf8_decode($bootsname),0,2);

$pdf -> MultiCell($etiketten_breite_beschreibbar,$zeilen_hoehe,$shirt_string,0,2);
?>
