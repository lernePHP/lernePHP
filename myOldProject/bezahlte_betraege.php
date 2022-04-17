<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

debug_to_console("Hallo in bezahlte_betraege.php");

//Eingang: $teilnehmer_id
//Ausgang: $bezahlte_betraege

//ermittelt die gesamten bezahlten Beträge zu einem Boot
//also hoehe_anzahlung + hoehe_zahlung1 + hoehe_zahlung2 + hoehe_zahlung3 + hoehe_zahlung4


include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
//debug_to_console("nach include von connection.php");


//wenn keine teilnehmer_id übergeben wurde, dann die
if (!$teilnehmer_id) die;

//Teilnehmer-Boot mit der übergebenen id selektieren

//sql-Statement erstellen
$sql_teilnehmer_boot="SELECT * ";
$sql_teilnehmer_boot.="FROM tbl_teilnehmer_boot ";
$sql_teilnehmer_boot.="WHERE teilnehmer_id=".$teilnehmer_id;
//echo "<br>".$sql."<br>";
  
$statement_teilnehmer_boot = $mydb->prepare($sql_teilnehmer_boot);

if ($statement_teilnehmer_boot->execute()) {}


//Recordset durchwandern,Daten als Variablen abspeichern
//der Recordset enthält genau einen Datensatz!
while ($akt_zeile_teilnehmer_boot=$statement_teilnehmer_boot->fetch())
	{
	//es kann zwar sein, dass sess_regatta_id schon zugewiesen ist, aber
	//es kann auch sein, dass das noch nicht passiert ist (z.B. bei Login als Teilnehmer)
	$_SESSION['sess_regatta_id']=$akt_zeile_teilnehmer_boot["regatta_fid"];		 
	$hoehe_anzahlung=$akt_zeile_teilnehmer_boot["hoehe_anzahlung"]; 
	$hoehe_zahlung2=$akt_zeile_teilnehmer_boot["hoehe_zahlung2"]; 	
	$hoehe_zahlung3=$akt_zeile_teilnehmer_boot["hoehe_zahlung3"]; 	
	$hoehe_zahlung4=$akt_zeile_teilnehmer_boot["hoehe_zahlung4"]; 		
	}
	
$bezahlte_betraege = $hoehe_anzahlung + $hoehe_zahlung2 + $hoehe_zahlung3 + + $hoehe_zahlung4;
debug_to_console("Ende von bezahlte_betraege.php");
?>