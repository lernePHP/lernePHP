<?php

//diese Datei ermittelt die Daten eines Crewmitgliedes aus tbl_crewmitglied mit $crewmitglied_id als crewmitglied_id.
//dazu muss der Wert von $crewmitglied_id vor dem Indludieren dieser Datei feststehen.

//als Variablen abgespeichert und danach in der includierten php-Datei verfügbar sind:
//$crewmitglied_name im Format Vorname + " " + Nachname

//sucht in der tbl_crewmitglied nach den Crewmitglied-Daten, die dann weiterverwendet werden können,

session_start();  //brauch ich hier nicht mehr, weil die Datei, wo teilnehmer_suchen includiert ist, die session schon gestartet hat

//wenn keine crewmitglied_id übergeben wurde, dann die
if (!$crewmitglied_id) die;

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

  //Teilnehmer-Boot mit der übergebenen id selektieren

  //sql-Statement erstellen
  $sql_crewmitglied="SELECT crewmitglied_id, teilnehmer_fid,Nachname,Vorname,Email, staatsbuergerschaft_Nr, ";
  $sql_crewmitglied.="passnr, geb_ort, geb_datum, mobil_nummer_vor_ort, mobil_nummer_zu_hause, Club, oesv_nr, PLZ, Ort, Land, Strasse, Shirt, unterschrieben ";
  $sql_crewmitglied.="FROM tbl_crewmitglied ";
  $sql_crewmitglied.="WHERE crewmitglied_id=".$crewmitglied_id;
	
	$statement_crewmitglied = $mydb -> prepare($sql_crewmitglied);
	if ($statement_crewmitglied->execute()) {}

  //Recordset durchwandern,Daten als Variablen abspeichern
  //der Recordset enthält genau einen Datensatz!
  while ($akt_zeile_crewmitglied=$statement_crewmitglied->fetch())
		 {
		 $crewmitglied_vorname=$akt_zeile_crewmitglied["Vorname"];
		 $crewmitglied_nachname=$akt_zeile_crewmitglied["Nachname"];
		 $crewmitglied_name=$akt_zeile_crewmitglied["Vorname"]." ".$akt_zeile_crewmitglied["Nachname"];
		 $crewmitglied_email=$akt_zeile_crewmitglied["Email"];
		 
		 $staatsbuergerschaft_Nr=$akt_zeile_crewmitglied["staatsbuergerschaft_Nr"];
		 include $_SERVER['DOCUMENT_ROOT'].'/staatsbuergerschaft_deutsch.php';		 
		 $crewmitglied_staatsbuergerschaft=$staatsbuergerschaft;
		 
		 $crewmitglied_passnr=$akt_zeile_crewmitglied["passnr"];
		 $crewmitglied_geb_ort=$akt_zeile_crewmitglied["geb_ort"];
		 $crewmitglied_geb_datum=$akt_zeile_crewmitglied["geb_datum"];
		 $crewmitglied_club=$akt_zeile_crewmitglied["Club"];
		 $crewmitglied_mobil_nummer_vor_ort=$akt_zeile_crewmitglied["mobil_nummer_vor_ort"];
		 $crewmitglied_mobil_nummer_zu_hause=$akt_zeile_crewmitglied["mobil_nummer_zu_hause"];
		 $crewmitglied_oesv_nr=$akt_zeile_crewmitglied["oesv_nr"];
		 $crewmitglied_plz=$akt_zeile_crewmitglied["PLZ"];
		 $crewmitglied_ort=$akt_zeile_crewmitglied["Ort"];
		 $crewmitglied_land=$akt_zeile_crewmitglied["Land"];
		 $crewmitglied_strasse=$akt_zeile_crewmitglied["Strasse"];
		 $crewmitglied_shirt=$akt_zeile_crewmitglied["Shirt"];
		 $crewmitglied_unterschrieben=$akt_zeile_crewmitglied["unterschrieben"];				 	 
		 }
?>