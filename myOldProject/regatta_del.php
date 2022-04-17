<?php
//hier wird die übergebene Regatta mitsamt seinen zugehörigen Detailtabellen gelöscht.
//wenn keine id übergeben wurde, dann die
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

if (isset($_GET['loeschen']))
{
    //zunächst Abfrage erstellen mit allen beroffenen Booten, diese Abfrage stimmt
	$sql_all="SELECT teilnehmer_id FROM tbl_teilnehmer_boot WHERE regatta_fid=".$_GET['regatta_id'];
	
	
	$statement_all = $mydb -> prepare($sql_all);
	if ($statement_all->execute()) {}
	

	
	//alle Teilnehmer-Boote durchlaufen
	if (($statement_all->rowCount() == 0))		//es sind keine Datensätze im Recordsetzt
	{
		//es sind keine Datensätze vorhanden. Entweder wurde der "Fragezeichen-Teil" in der Adresse nicht übergeben oder die übergebene Regatte_Nummer existiert nicht
		//in jedem Fall soll zur regattaliste zurückgekehrt und der Code abgebrochen werdne
		Header("location:http://".$_SERVER['SERVER_NAME']."/regattaliste.php");
		die;
	}	
	else
	{
		debug_to_console("Anzahl Datensätze: ".$statement_all->rowCount());
		while ($akt_zeile=$statement_all->fetch())
		{
				//Abfrage mit allen Crewmitgliedern für das aktuelle Teilnehmer-Boot definieren und Crewmitglieder ds aktuellen Teilnehmer-Bootes löschen
				$sql="DELETE FROM tbl_crewmitglied WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}
				
			
				//Abfrage mit allen Rechnungen für das aktuelle Teilnehmer-Boot definieren und Rechnungen des aktuellen 				//Teilnehmer-Bootes löschen
				$sql="DELETE FROM tbl_rechnungen WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}

			
		
				//Abfrage mit den Benutzerrechten für das aktuelle Teilnehmer-Boot definieren und Benutzerrechte
				//des aktuellen Teilnehmer-Bootes löschen
				$sql="DELETE FROM tbl_benutzerrechte WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}


				
				//Abfrage mit allen Kautions-Annahmen für das aktuelle Teilnehmer-Boot definieren und Kautions-Annahmen			
				//des aktuellen Teilnehmer-Bootes löschen
				$sql="DELETE FROM `tbl_kautions_annahme` WHERE teilnehmer_id =".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}
			
				//Abfrage mit allen Kautions-Rückgaben für das aktuelle Teilnehmer-Boot definieren und 		
				//Kautions-Rückgaben			
				//des aktuellen Teilnehmer-Bootes löschen
				$sql="DELETE FROM `tbl_kautions_rueckgabe` WHERE teilnehmer_id =".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}

		}
	}

	//alle Teilnehmerboote mit der übergebenen Regatta_id löschen
	$sql="DELETE FROM tbl_teilnehmer_boot WHERE regatta_fid=".$_GET['regatta_id'];	
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}

	//den der übergebenen Regatta zugehörigen Gruppenbestand löschen
	$sql="DELETE FROM tbl_gruppen_bestand WHERE regatta_fid=".$_GET['regatta_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}

	
	//die der übergebenen Regatta zugehörigen Gruppen löschen
	$sql="DELETE FROM tbl_gruppe WHERE regatta_fid=".$_GET['regatta_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
	
	//die übergebene Regatta löschen
	$sql="DELETE FROM tbl_regatta WHERE regatta_id=".$_GET['regatta_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
	
	//das mache ich in der Hoffnung, dass die Regattaliste aktualiisiert wird beim erneuten Anzeigen.
	$sql="SELECT regatta_id FROM tbl_regatta";
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
}
//Header("location:http://".$_SERVER['SERVER_NAME']."/regattaliste.php");
Header("location:http://".$_SERVER['SERVER_NAME']."/regattaliste.php");
//$_SERVER['SERVER_NAME']
?>
