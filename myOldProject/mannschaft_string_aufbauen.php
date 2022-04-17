<?php
//**************************************************************************************************************
//Hier wird - zur Ausgabe in ein pdf-File über zertifikate_dateninhalte_aufbauen.php - ein String aufgebaut
//in dem alle Namen einer Mannschaft, inklusive Skipper, enthalten sind. Beginnend mit dem Skipper, gefolgt von den
//crewmitgliedern. Nach dem Format:
//Gert Schmidleitner, Michaela Schmidleitner, Max Schmidleitner, Carolin Schmidleitner
//Falls die Länge des Strings länger ist wie die Übergebene Anzahl der Zeichen ($max_anz_zeichen), so soll
//ein Zeilenumbruch ("\n") eingefügt werden, also ungefähr so:
//"Gert Schmidleitner, Max Schmidleitner, Michaela Schmidleitner, Carolin Schmidleitner \n
//Kurt L. Müller, Sabine Meier, Gudrun Schaffer"
//
//Variablen-Eingang: (muss in der Datei, in der das Include eingefügt wird, definiert sein)
//$teilnehmer_nr
//$skipper_name
//$max_anz_zeichen
//
//Ausgang: $mannschaft_string
//***************************************************************************************************************

$mannschaft_string ="";
$mannschaft_string_laenge=0;

//*******************************************
//alle nötigen Variablen-Eingänge vorhanden?
if (!$teilnehmer_id) die;
if (!$skipper_name) die;
if (!$max_anz_zeichen) die;
//*******************************************


//*******************************************
//Skipper-Name in den String aufnehmen
$mannschaft_string =$skipper_name;		//skipper_name steht immer als erstes im String
$zeilen_string_laenge =strlen($mannschaft_string);
//-------------------------------------------


//*******************************************
//Crewmitglieder an den Mannschafts-String anhängen
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//sql-Statement erstellen
$sql_crewmitglied="SELECT teilnehmer_fid,Nachname,Vorname ";
$sql_crewmitglied.="FROM tbl_crewmitglied ";
$sql_crewmitglied.="WHERE teilnehmer_fid=".$teilnehmer_id;
$sql_crewmitglied.=" ORDER BY Nachname,Vorname";

$statement_crewmitglied = $mydb -> prepare($sql_crewmitglied);
if ($statement_crewmitglied->execute()) {}

//Recordset durchwandern,Daten als Variablen abspeichern
while ($akt_zeile_crewmitglied=$statement_crewmitglied->fetch())
{
	$neuer_name=$akt_zeile_crewmitglied["Vorname"]." ".$akt_zeile_crewmitglied["Nachname"];
	$neuer_name_laenge=strlen($neuer_name);
	if (($zeilen_string_laenge+4+$neuer_name_laenge) > $max_anz_zeichen)	//2x2 Zeichen dazuzählen für ", "
	{
		//das Hinzufügen des neuen Namens würde die maximale Zeichenlänge einer Zeile überschreiten
		//deshalb muss vor dem neuen Namen ein "\n" hinzugefügt werden für einen Zeilenumbruch
		$mannschaft_string = $mannschaft_string.", \n ".$neuer_name;
		$zeilen_string_laenge=$neuer_name_laenge;
	}
	else
	{
		$mannschaft_string=$mannschaft_string.", ".$neuer_name;
		$zeilen_string_laenge=$zeilen_string_laenge+2+$neuer_name_laenge;
	}
}
//---------------------------------------------

?>