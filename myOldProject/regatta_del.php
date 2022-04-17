<?php
//hier wird die �bergebene Regatta mitsamt seinen zugeh�rigen Detailtabellen gel�scht.
//wenn keine id �bergeben wurde, dann die
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

if (isset($_GET['loeschen']))
{
    //zun�chst Abfrage erstellen mit allen beroffenen Booten, diese Abfrage stimmt
	$sql_all="SELECT teilnehmer_id FROM tbl_teilnehmer_boot WHERE regatta_fid=".$_GET['regatta_id'];
	
	
	$statement_all = $mydb -> prepare($sql_all);
	if ($statement_all->execute()) {}
	

	
	//alle Teilnehmer-Boote durchlaufen
	if (($statement_all->rowCount() == 0))		//es sind keine Datens�tze im Recordsetzt
	{
		//es sind keine Datens�tze vorhanden. Entweder wurde der "Fragezeichen-Teil" in der Adresse nicht �bergeben oder die �bergebene Regatte_Nummer existiert nicht
		//in jedem Fall soll zur regattaliste zur�ckgekehrt und der Code abgebrochen werdne
		Header("location:http://".$_SERVER['SERVER_NAME']."/regattaliste.php");
		die;
	}	
	else
	{
		debug_to_console("Anzahl Datens�tze: ".$statement_all->rowCount());
		while ($akt_zeile=$statement_all->fetch())
		{
				//Abfrage mit allen Crewmitgliedern f�r das aktuelle Teilnehmer-Boot definieren und Crewmitglieder ds aktuellen Teilnehmer-Bootes l�schen
				$sql="DELETE FROM tbl_crewmitglied WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}
				
			
				//Abfrage mit allen Rechnungen f�r das aktuelle Teilnehmer-Boot definieren und Rechnungen des aktuellen 				//Teilnehmer-Bootes l�schen
				$sql="DELETE FROM tbl_rechnungen WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}

			
		
				//Abfrage mit den Benutzerrechten f�r das aktuelle Teilnehmer-Boot definieren und Benutzerrechte
				//des aktuellen Teilnehmer-Bootes l�schen
				$sql="DELETE FROM tbl_benutzerrechte WHERE teilnehmer_fid=".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}


				
				//Abfrage mit allen Kautions-Annahmen f�r das aktuelle Teilnehmer-Boot definieren und Kautions-Annahmen			
				//des aktuellen Teilnehmer-Bootes l�schen
				$sql="DELETE FROM `tbl_kautions_annahme` WHERE teilnehmer_id =".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}
			
				//Abfrage mit allen Kautions-R�ckgaben f�r das aktuelle Teilnehmer-Boot definieren und 		
				//Kautions-R�ckgaben			
				//des aktuellen Teilnehmer-Bootes l�schen
				$sql="DELETE FROM `tbl_kautions_rueckgabe` WHERE teilnehmer_id =".$akt_zeile["teilnehmer_id"];
	
				$statement = $mydb -> prepare($sql);
				if ($statement->execute()) {}

		}
	}

	//alle Teilnehmerboote mit der �bergebenen Regatta_id l�schen
	$sql="DELETE FROM tbl_teilnehmer_boot WHERE regatta_fid=".$_GET['regatta_id'];	
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}

	//den der �bergebenen Regatta zugeh�rigen Gruppenbestand l�schen
	$sql="DELETE FROM tbl_gruppen_bestand WHERE regatta_fid=".$_GET['regatta_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}

	
	//die der �bergebenen Regatta zugeh�rigen Gruppen l�schen
	$sql="DELETE FROM tbl_gruppe WHERE regatta_fid=".$_GET['regatta_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
	
	//die �bergebene Regatta l�schen
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
