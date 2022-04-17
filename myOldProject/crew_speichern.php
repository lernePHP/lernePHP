<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crew_speichern.php");




session_start();
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//hierher wird nur verzeigt, wenn ein neues Crewmitglied eingegeben wurde, 
//crewmitglied_id ist ein Auto_increment-Feld und muss daher nicht eingegeben werden
//teilnehmer_fid wird als teilnehmer_id direkt im Aufruf der Seite übergeben (z.B. crew_speichern?teilnehmer_id=1
//if ($speichern=="speichern")
//        {
        //es wurde auf SPEICHERN gedrückt
        //überprüfung der Daten erfolgte bereits auf der vorigen Seite
		
		 $sql="INSERT INTO tbl_crewmitglied (teilnehmer_fid,Nachname,Vorname,Strasse,PLZ,Ort,Land,Email,Club,Shirt,mobil_nummer_zu_hause";
		 $sql.=",mobil_nummer_vor_ort,oesv_nr,geb_datum,geb_ort,staatsbuergerschaft_Nr,passnr,unterschrieben) ";
		 $sql.="VALUES ('".$_SESSION['sess_login_teilnehmer_id']."','".$_POST['nachname']."','".$_POST['vorname']."','".$_POST['strasse']."','";
		 $sql.=$_POST['plz']."','".$_POST['ort']."','".$_POST['land']."','".$_POST['email']."','";
		 $sql.=$_POST['club']."','".$_POST['shirt']."','".$_POST['mobil_nummer_zu_hause']."','";
		 $sql.=$_POST['mobil_nummer_vor_ort']."','".$_POST['oesv_nr']."','".$_POST['geb_datum']."','";
		 $sql.=$_POST['geb_ort']."','".$_POST['staatsbuergerschaft_Nr']."','".$_POST['passnr']."','".$_POST['unterschrieben']."')";
	
		$statement = $mydb -> prepare($sql);
		if ($statement->execute()) {}

		$crewmitglied_id=$mydb->lastInsertId();	//gibt jene ID zurück, die beim letzten Insert als Autoincrement-Wert vergeben wurde.
		
//        }
$header="location:http://".$_SERVER['SERVER_NAME']."/crewliste.php?teilnehmer_id=".$_SESSION['sess_login_teilnehmer_id'];
Header($header);


debug_to_console("Ende crew_speichern.php");
?>