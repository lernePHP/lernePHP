<?php
//echo "<br>crewliste_pdf passieren";
//***************************************************************************************************
//Eingabe: $teilnehmer_id muss als Variable in der aufrufenden Datei festgelegt werden
// Include von crewliste_pdf_doc_erstellen, um ein PDF-Dokument zu estellen und die Dokument-Eigenschaften
// zu initialisieren
//Ausgabe: Crewliste als pdf
//***************************************************************************************************
//echo "teilnehmer: ".$teilnehmer_id;

//nur wenn eine einzelne Crewliste gedruckt wird, soll ein neues PDF-Dokument erstellt werden
//ansonsten erfolgt das Erstellen des neuen PDF-Dokumentes in crewliste_pdf_alle_boote.php
//echo "<br> crewliste_pdf wird passiert";
if ($nur_einer == 1) {
	include $_SERVER['DOCUMENT_ROOT'].'/crewliste_pdf_doc_erstellen.php';
}

//******************************** Skipper-Daten verfügbar machen *****************************************
include $_SERVER['DOCUMENT_ROOT'].'/teilnehmer_suchen.php';		//ab hier sind die skipper- und Boots-Daten verfügbar
										//Voraussetzung: $teilnehmer_id muss gesetzt sein
										//sessen_start() und connection.php wird hier aufgerufen

$TN_passnr=$passnr;		//muss ich mir merken, weil die $passnr dazwischen einmal auf "Passnummer" geändert wird
//********************************* regatta_id und danach Veranstaltungsdaten ermitteln **********************
//$_SESSION['sess_regatta_id'] wird in teilnehmer_suchen.php gesetzt
$regatta_id=$_SESSION['sess_regatta_id'];
include $_SERVER['DOCUMENT_ROOT'].'/regatta_suchen.php';			//danach ist $regatta_name verfügbar

//*******************************************************

//*******************************************************
//Neue Seite einfügen. Falls keine Parameter übergeben werden, werden die Parameter von FPDF übernommen
//(Hoch / Querformat ...
//AddPage([string orientation])
$pdf -> AddPage();
//echo "<br>Neue Seite erzeugen";

//header erzeugen, anschließend wird Y auf $tabellen_position gesetzt
include $_SERVER['DOCUMENT_ROOT'].'/header_pdf.php';
//echo "<br>Header einfügen";
//*******************************************************

//echo "header blabla";
$pdf -> SetY($tabellen_position);

//******************************** Überschriften-Zeile einfügen *****************************************
$nr="Nr.";
$name="Vorname, Nachname";
$nationalitaet="Nationalität";
$passnr="Passnummer";
$geburt="Geburtsort und -datum";

include $_SERVER['DOCUMENT_ROOT'].'/crewliste_zeile_drucken.php';
//echo "<br>Überschriftenzeile einfügen";
//**************************** Überschriften-Zeile einfügen - Ende **************************************

$nr="Skipper";
$name = utf8_decode($skipper_vorname.", ".$skipper_nachname);
$nationalitaet=utf8_decode($skipper_staatsbuergerschaft);
$passnr=$TN_passnr;
$geburt=utf8_decode($geb_ort).", ".$geb_datum;

include $_SERVER['DOCUMENT_ROOT'].'/crewliste_zeile_drucken.php';
//echo "crewliste_zeile_drucken Skipper blabla";
//**************************** Skipper-Zeile einfügen - Ende **************************************

//******************************** Zeile für die Crew-Mitglieder einfügen *******************************
//laufende Durchnumerierung der Crewmitglieder
$nr=2;		//die Durchnummerierung der Crewmitglieder beginnt mit 2, da Nr. 1 der Skipper ist.

//sql-Statement erstellen
//teilnehmer_id wird übergeben
$sql_crew="SELECT crewmitglied_id,teilnehmer_fid,nachname,vorname, staatsbuergerschaft_Nr,passnr,geb_datum,geb_ort FROM tbl_crewmitglied ";
$sql_crew.="WHERE (teilnehmer_fid=".$teilnehmer_id.") ORDER BY nachname,vorname";
	
$statement_crew = $mydb -> prepare($sql_crew);
if ($statement_crew->execute()) {}


while ($akt_zeile_crew=$statement_crew->fetch()) {
	   //Variablen für das Include von crewliste_zeile_drucken.php initialisieren

		//$nr wird vor der Schleife zugewiesen bzw. am Ende der Schleife erhöht
		$name=utf8_decode($akt_zeile_crew["vorname"].", ".$akt_zeile_crew["nachname"]);


		$staatsbuergerschaft_Nr =$akt_zeile_crew["staatsbuergerschaft_Nr"];				
		//Staatsbürgerschaft des Vorschoters: VOR diesem Include muss die Variable $staatsbuergerschaft_Nr zugewiesen sein
		include $_SERVER['DOCUMENT_ROOT'].'/staatsbuergerschaft_deutsch.php';
		$nationalitaet = utf8_decode($staatsbuergerschaft);


		$passnr=$akt_zeile_crew["passnr"];
		$geburt=utf8_decode($akt_zeile_crew["geb_ort"]).", ".$akt_zeile_crew["geb_datum"];

		include $_SERVER['DOCUMENT_ROOT'].'/crewliste_zeile_drucken.php';	
		//echo "<br> crew blabla";	   
	   //lfd. Nr erhöhen
	   $nr++;
}

//************************ Zeile für die Crew-Mitglieder einfügen - Ende ********************************
				
if ($nur_einer == 1) {
	//Ausgeben des aktuellen PDF-Files
	$pdf -> output();
	//echo "<br>Nur einer";
}
//*******************************************************
?>
