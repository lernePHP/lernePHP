<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in regatta_suchen.php");

//echo "<br> regatta_id: ".$regatta_id;
//$regatta_id muss zuvor in der php-Datei, wo das include eingefügt wird, als session-Variable feststehen.
//session_start(); ist nicht notwendig, weil dort, wo diese php-Datei aufgerufen wird, bereits ein session-start durchgeführt wurde

//als Variablen abgespeichert und danach in der includierten php-Datei verfügbar sind:
//$regatta_name
//$regatta_beginn
//$regatta_ende
//$rechnungs_pfad

//sucht in der tbl_regatta nach den Regatta_Daten, die dann weiterverwendet werden können,
//regatta_name, regatta_beginn, regatta_ende, ...

//echo "<br> test5";
//echo "<br> regatta_id in regatta_suchen.php: ".$sess_regatta_id;

//wenn keine regatta_id übergeben wurde, dann die

//dieses lalala zeigt er an
//echo lalala;

//echo "regatta_id: ".$_SESSION['sess_regatta_id'];
if (!$_SESSION['sess_regatta_id']) die;					//scheinbar hat php ein Problem mit der Zuordnung bzw. dem Vergleich =="";
											//daher if (!$sess_regatta_id) die; statt if (!$sess_regatta_id=="");

//dieses lala zeigt er nicht mehr an
//echo lalala;


//echo "regatta_suchen.php";			

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

if (!$mydb) {
	//debug_to_console("regatta_suchen: mydb nicht definiert!");
}
else {
	//debug_to_console("regatta_suchen: mydb ist definiert");
}

  //Regatta mit der übergebenen id selektieren

  //sql-Statement erstellen
  $sql_regatta="SELECT regatta_id,Regatta_Name,restzahlungen_verschickt,regatta_kuerzel,damen_shirts,kornati_cup,rechnungs_pfad, Regatta_Beginn,Regatta_Ende, Veranstaltungslogo,  Disclaimer,Kosten_erm_Boot,Kosten_Boot,Kosten_Person,Fruehzahler_Datum,restzahlung_faellig_bis,restzahlungen_verschickt,letzte_rg_nr,Anzahlungshoehe, zertifikate_pfad, unverbindliche_Anmeldung ";
  $sql_regatta.="FROM tbl_regatta ";
  $sql_regatta.="WHERE regatta_id=".$_SESSION['sess_regatta_id'];
  //echo $sql;

  $statement_regatta = $mydb->prepare($sql_regatta);	

	if ($statement_regatta->execute()) {
		while ($akt_zeile_regatta = $statement_regatta->fetch()) {
			$regatta_name=$akt_zeile_regatta["Regatta_Name"];
			$restzahlungen_verschickt = $akt_zeile_regatta["restzahlungen_verschickt"];
			$regatta_kuerzel=$akt_zeile_regatta["regatta_kuerzel"];
			$damen_shirts=$akt_zeile_regatta["damen_shirts"];	//ja/nein-Feld
			$kornati_cup=$akt_zeile_regatta["kornati_cup"];
			$regatta_beginn=$akt_zeile_regatta["Regatta_Beginn"];
			$regatta_ende=$akt_zeile_regatta["Regatta_Ende"];
			$veranstaltungslogo = $akt_zeile_regatta["Veranstaltungslogo"];
			$rechnungs_pfad=$akt_zeile_regatta["rechnungs_pfad"];
			$disclaimer=$akt_zeile_regatta["Disclaimer"];
			$kosten_erm_boot=$akt_zeile_regatta["Kosten_erm_Boot"];
			$kosten_boot=$akt_zeile_regatta["Kosten_Boot"];
			$kosten_person=$akt_zeile_regatta["Kosten_Person"];		 
			$fruehzahler_datum=$akt_zeile_regatta["Fruehzahler_Datum"];
			$restzahlung_faellig_bis = $akt_zeile_regatta["restzahlung_faellig_bis"];
			$letzte_rg_nr=$akt_zeile_regatta["letzte_rg_nr"];	
			$anzahlungshoehe=$akt_zeile_regatta["Anzahlungshoehe"];	
			$termin=strftime("%d.%m.%Y",strtotime($regatta_beginn))." - ".strftime("%d.%m.%Y",strtotime($regatta_ende));
			$zertifikate_pfad = $akt_zeile_regatta["zertifikate_pfad"];	
			$unverbindliche_Anmeldung = $akt_zeile_regatta["unverbindliche_Anmeldung"];				
		}
	}
debug_to_console("Ende von regatta_suchen.php");
?>
