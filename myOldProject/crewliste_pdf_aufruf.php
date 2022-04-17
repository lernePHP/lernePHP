<?php
header("Content-Type: text/html; charset=utf-8");

session_start();

//diese Datei wird aus der Teilnehmerliste.php heraus aufgerufen und dient nur dazu, $teilnehmer_id zu
//setzen und danach die crewliste_pdf.php aufzurufen
//**************** Initialisierung der Variablen für das PDF ***********************************
$teilnehmer_id=$_GET['teilnehmer_id'];		//wird für teilnehmer_suchen.php benötigt - weiter unten
$nur_einer=$_GET['nur_einer'];		//ist 1, wenn nur eine Crewliste gedruckt wird, wenn alle Boots-Crewlisten gedruckt
									//werden sollen, dann ist der Wert von nur_einer 0
include $_SERVER['DOCUMENT_ROOT'].'/crewliste_pdf.php';
?>