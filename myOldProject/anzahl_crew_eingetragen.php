<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in anzahl_crew_eingetragen.php");


//Eingang: $teilnehmer_id

//$anzahl_crew_eingetragen gibt die Anzahl jener Crew-Mitglieder eines Bootes zurück, die in der Tabelle
//tbl_teilnehmer_boot eingetragen sind

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$anzahl_crew_eingetragen=0;

//wenn keine teilnehmer_id übergeben wurde, dann die
if (!$teilnehmer_id) die;

//gruppierte Abfrage erstellen, um die Anzahl der eingetragenen Crewmitglieder zu ermitteln

//sql-Statement erstellen
$sql_crew="SELECT teilnehmer_fid, Count( crewmitglied_id ) AS anzahl_crew_eingetragen ";
$sql_crew.="FROM tbl_crewmitglied ";
$sql_crew.="GROUP BY teilnehmer_fid ";
$sql_crew.="HAVING (teilnehmer_fid =".$teilnehmer_id.")";
			
$statement_crew = $mydb->prepare($sql_crew);
if ($statement_crew->execute()) {}
			


//Recordset durchwandern,Daten als Variablen abspeichern
//der Recordset enthält genau einen Datensatz!
while ($akt_zeile_crew=$statement_crew->fetch())
	{
	$anzahl_crew_eingetragen=$akt_zeile_crew["anzahl_crew_eingetragen"]; 	
	}

debug_to_console("Ende anzahl_crew_eingetragen.php");
?>