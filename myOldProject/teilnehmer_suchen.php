<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in teilnehmer_suchen.php");


//echo "<br> teilnehmer_id: ".$teilnehmer_id;
//diese Datei ermittelt die Teilnehmer-Dateien jenes Teilnehmers mit $teilnehmer_id als teilnehmer_id.
//dazu muss der Wert von $teilnehmer_id vor dem Indludieren dieser Datei feststehen.

//als Variablen abgespeichert und danach in der includierten php-Datei verfügbar sind:
//$regatta_id
//$skipper_name
//$bootstype

//sucht in der tbl_teilnehmer_boot nach den Teilnehmer-Daten, die dann weiterverwendet werden können,

session_start();  //brauch ich hier nicht mehr, weil die Datei, wo teilnehmer_suchen includiert ist, die session schon gestartet hat

//wenn keine teilnehmer_id übergeben wurde, dann die
debug_to_console("teilnehmer_id?");

if (!$teilnehmer_id) die;
debug_to_console("Nach Überprüfung teilnehmer_id");

//connection.php includieren
debug_to_console("vor include connection.php");
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
debug_to_console("nach include connection.php");

  //Teilnehmer-Boot mit der übergebenen id selektieren

  //sql-Statement erstellen
  $sql_teilnehmer="SELECT teilnehmer_id,regatta_fid,restzahlung_verschickt,Nachname,Vorname,Email,Bootstype, bootsname, staatsbuergerschaft_Nr, ";
  $sql_teilnehmer.="passnr, geb_ort, geb_datum, mobil_nummer_vor_ort, Club, oesv_nr, PLZ, Ort, Land, Strasse, Shirt, ";
  $sql_teilnehmer.="gruppen_fid, Sponsor, tiefgang, rat_gph_mit_spi, rat_gph_ohne_spi,rat_plti_mit_spi,rat_plti_ohne_spi, ";
  $sql_teilnehmer.="rat_pldi_mit_spi,rat_pldi_ohne_spi, rat_rms, startnummer,eigene_rg_adresse,rg_zeile1,rg_zeile2,rg_zeile3,rg_zeile4, Anzahl_Crew,hoehe_gutschrift1,text_gutschrift1,hoehe_gutschrift2,text_gutschrift2,ermaessigung ";
  $sql_teilnehmer.="FROM tbl_teilnehmer_boot ";
  $sql_teilnehmer.="WHERE teilnehmer_id=".$teilnehmer_id;


	$statement_teilnehmer = $mydb->prepare($sql_teilnehmer);
	if ($statement_teilnehmer->execute()) {}


  debug_to_console("nach execute von statement_teilnehmer");

  //Recordset durchwandern,Daten als Variablen abspeichern
  //der Recordset enthält genau einen Datensatz!
  while ($akt_zeile_teilnehmer=$statement_teilnehmer->fetch())
		 {
	  	 //debug_to_console("Beginn While statement_teilnehmer");
	  	 $skipper_restzahlung_verschickt= $akt_zeile_teilnehmer["restzahlung_verschickt"];	
		 $skipper_vorname=$akt_zeile_teilnehmer["Vorname"];
		 $skipper_nachname=$akt_zeile_teilnehmer["Nachname"];
		 $skipper_name=$akt_zeile_teilnehmer["Vorname"]." ".$akt_zeile_teilnehmer["Nachname"];
		 $bootstype=$akt_zeile_teilnehmer["Bootstype"];
		 $bootsname=$akt_zeile_teilnehmer["bootsname"];
		 $email=$akt_zeile_teilnehmer["Email"];
		 $passnr=$akt_zeile_teilnehmer["passnr"];
		 $geb_ort=$akt_zeile_teilnehmer["geb_ort"];
		 $geb_datum=$akt_zeile_teilnehmer["geb_datum"];
		 $club=$akt_zeile_teilnehmer["Club"];
		 $mobil_nummer_vor_ort=$akt_zeile_teilnehmer["mobil_nummer_vor_ort"];
		 $oesv_nr=$akt_zeile_teilnehmer["oesv_nr"];
		 $plz=$akt_zeile_teilnehmer["PLZ"];
		 $ort=$akt_zeile_teilnehmer["Ort"];
		 $land=$akt_zeile_teilnehmer["Land"];
		 $strasse=$akt_zeile_teilnehmer["Strasse"];
		 $shirt=$akt_zeile_teilnehmer["Shirt"];
		 $gruppen_fid=$akt_zeile_teilnehmer["gruppen_fid"];
		 $sponsor=$akt_zeile_teilnehmer["Sponsor"];
		 $tiefgang=$akt_zeile_teilnehmer["tiefgang"];
		 $rat_gph_mit_spi=$akt_zeile_teilnehmer["rat_gph_mit_spi"];
		 $rat_gph_ohne_spi=$akt_zeile_teilnehmer["rat_gph_ohne_spi"];
		 
		 $rat_plti_mit_spi=$akt_zeile_teilnehmer["rat_plti_mit_spi"];
		 $rat_plti_ohne_spi=$akt_zeile_teilnehmer["rat_plti_ohne_spi"];
		 		 
		 $rat_pldi_mit_spi=$akt_zeile_teilnehmer["rat_pldi_mit_spi"];
		 $rat_pldi_ohne_spi=$akt_zeile_teilnehmer["rat_pldi_ohne_spi"];
	  
	  	 $rat_rms=$akt_zeile_teilnehmer["rat_rms"];
		 	 		 
		 $startnummer=$akt_zeile_teilnehmer["startnummer"];	
		 $eigene_rg_adresse=$akt_zeile_teilnehmer["eigene_rg_adresse"];			 
		 $rg_zeile1=$akt_zeile_teilnehmer["rg_zeile1"];	
		 $rg_zeile2=$akt_zeile_teilnehmer["rg_zeile2"];	
		 $rg_zeile3=$akt_zeile_teilnehmer["rg_zeile3"];	
		 $rg_zeile4=$akt_zeile_teilnehmer["rg_zeile4"];	
		 $anzahl_crew=$akt_zeile_teilnehmer["Anzahl_Crew"];	
		 $hoehe_gutschrift1=$akt_zeile_teilnehmer["hoehe_gutschrift1"];			 
		 $text_gutschrift1=$akt_zeile_teilnehmer["text_gutschrift1"];			 
		 $hoehe_gutschrift2=$akt_zeile_teilnehmer["hoehe_gutschrift2"];			 
		 $text_gutschrift2=$akt_zeile_teilnehmer["text_gutschrift2"];		 
		 $ermaessigung=$akt_zeile_teilnehmer["ermaessigung"];	
		 $staatsbuergerschaft_Nr =$akt_zeile_teilnehmer["staatsbuergerschaft_Nr"];	
		 
	    //debug_to_console("vor include staatsbuergerschaft_deutsch.php");
	  
		 //Staatsbürgerschaft des Skippers: VOR diesem Include muss die Variable $staatsbuergerschaft_Nr zugewiesen sein
		include $_SERVER['DOCUMENT_ROOT'].'/staatsbuergerschaft_deutsch.php';
		$skipper_staatsbuergerschaft = $staatsbuergerschaft;
		
	  
	    //debug_to_console("nach include staatsbuergerschaft_deutsch.php");
	  
		//falls bootsname leer ist, so soll bei Yacht nur die Yachttype stehen,
		//sonst soll dort [Yachttype "Yachtame"] stehen
		if ($bootsname=="") {
			$yacht=$bootstype;
		}
		else {
			$yacht=$bootstype.' "'.$bootsname.'"';
		}
		 	 
		 $_SESSION['sess_regatta_id']=$akt_zeile_teilnehmer["regatta_fid"];		//es kann zwar sein, dass sess_regatta_id schon zugewiesen ist, aber 
		 													//es kann auch sein, dass das noch nicht passiert ist (z.B. bei Login als Teilnehmer)
		 }
debug_to_console("Ende teilnehmer_suchen.php");
?>