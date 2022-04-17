<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in teilnehmer_eingabe.php");


header("Content-Type: text/html; charset=utf-8");
session_start();		//damit ich auf sess_regatta_id zugreifen kann ...


include $_SERVER['DOCUMENT_ROOT'].'/regatta_suchen.php';
$_SESSION['unverbindliche_Anmeldung']=$unverbindliche_Anmeldung;

$sprache = $_SESSION['sprache'];

$regatta_id=$_GET['regatta_id'];
$_SESSION['sess_regatta_id']=$regatta_id;

if (isset($_POST["gesendet"])) {
  formverarbeiten();
} 
else {
	formausgeben();
}

function formverarbeiten()
{
  isset($_POST["nachname"]) && is_string($_POST["nachname"]) ? $nachname = trim($_POST["nachname"]) : $nachname= "";
  isset($_POST["vorname"])  && is_string($_POST["vorname"])  ? $vorname =  trim($_POST["vorname"]) : $vorname= "";
  isset($_POST["strasse"])  && is_string($_POST["strasse"])  ? $strasse =  trim($_POST["strasse"]) : $strasse= "";
  isset($_POST["plz"])  && is_string($_POST["plz"])  ? $plz =  trim($_POST["plz"]) : $plz= "";
  isset($_POST["ort"])  && is_string($_POST["ort"])  ? $ort =  trim($_POST["ort"]) : $ort= "";
  isset($_POST["land"])  && is_string($_POST["land"])  ? $land =  trim($_POST["land"]) : $land= "";
  isset($_POST["geb_datum"]) ? $geb_datum =  $_POST["geb_datum"] : $geb_datum= "";
  isset($_POST["geb_ort"])  && is_string($_POST["geb_ort"])  ? $geb_ort =  trim($_POST["geb_ort"]) : $geb_ort= "";
  isset($_POST["staatsbuergerschaft_Nr"])  ? $staatsbuergerschaft_Nr = $_POST["staatsbuergerschaft_Nr"] : $staatsbuergerschaft_Nr= 0;
  isset($_POST["passnr"])  && is_string($_POST["passnr"])  ? $passnr =  trim($_POST["passnr"]) : $passnr= "";
  isset($_POST["email"])  && is_string($_POST["email"])  ? $email =  trim($_POST["email"]) : $email= "";
  isset($_POST["mobil_nummer_zu_hause"])  && is_string($_POST["mobil_nummer_zu_hause"])  ? $mobil_nummer_zu_hause =  trim($_POST["mobil_nummer_zu_hause"]) : $mobil_nummer_zu_hause= "";
  isset($_POST["mobil_nummer_vor_ort"])  && is_string($_POST["mobil_nummer_vor_ort"])  ? $mobil_nummer_vor_ort =  trim($_POST["mobil_nummer_vor_ort"]) : $mobil_nummer_vor_ort= "";
  isset($_POST["club"])  && is_string($_POST["club"])  ? $club =  trim($_POST["club"]) : $club= "";
  isset($_POST["oesv_nr"])  ? $oesv_nr = $_POST["oesv_nr"] : $oesv_nr= "";
  isset($_POST["shirt"])  && is_string($_POST["shirt"])  ? $shirt =  trim($_POST["shirt"]) : $shirt= "";
  isset($_POST["sponsor"])  && is_string($_POST["sponsor"])  ? $sponsor =  trim($_POST["sponsor"]) : $sponsor= "";
  isset($_POST["bootstype"])  && is_string($_POST["bootstype"])  ? $bootstype =  trim($_POST["bootstype"]) : $bootstype= "";
  isset($_POST["bootsname"])  && is_string($_POST["bootsname"])  ? $bootsname =  trim($_POST["bootsname"]) : $bootsname= "";
  isset($_POST["gruppen_fid"])  ? $gruppen_fid = $_POST["gruppen_fid"] : $gruppen_fid= 0;
  isset($_POST["tiefgang"])  ? $tiefgang = $_POST["tiefgang"] : $tiefgang= "";
  isset($_POST["anzahl_crew"])  ? $anzahl_crew = $_POST["anzahl_crew"] : $anzahl_crew= "";
  
  
  if (isset($_POST["unterschrieben"])) {
  
	if ($_POST['unterschrieben']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$unterschrieben=1;	
	}
	else {
		$unterschrieben=0;
	}
  }
  else {
  	$unterschrieben=0;
  }	

  if (isset($_POST["eigene_rg_adresse"])) {
  
	if ($_POST['eigene_rg_adresse']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$eigene_rg_adresse=1;	
	}
	else {
		$eigene_rg_adresse=0;
	}
  }
  else {
  	$eigene_rg_adresse=0;
  }	
  
  isset($_POST["rg_zeile1"])  && is_string($_POST["rg_zeile1"])  ? $rg_zeile1 =  trim($_POST["rg_zeile1"]) : $rg_zeile1= "";
  isset($_POST["rg_zeile2"])  && is_string($_POST["rg_zeile2"])  ? $rg_zeile2 =  trim($_POST["rg_zeile2"]) : $rg_zeile2= "";
  
  isset($_POST["rg_zeile3"])  && is_string($_POST["rg_zeile3"])  ? $rg_zeile3 =  trim($_POST["rg_zeile3"]) : $rg_zeile3= "";
  isset($_POST["rg_zeile4"])  && is_string($_POST["rg_zeile4"])  ? $rg_zeile4 =  trim($_POST["rg_zeile4"]) : $rg_zeile4= "";
	
	global $sprache;
	global $unverbindliche_Anmeldung;
	
  $fehler = "";
  
	//überprüfen, ob die ausgewählte Gruppe noch freie Boote hat
	$regatta_id=$_GET['regatta_id'];
	$gruppen_id=$_POST['gruppen_fid'];
	
	
	
	
	
	//*********************************************************
	//email-Adresse gültig -> Überprüfung mittels externem Tool
	//dieses Tool überprüft nicht nur die Syntax, sondern, ob an diese Adresse tatsächlich Mails verschickt werden können
	include $_SERVER['DOCUMENT_ROOT'].'/email_adresse_pruefen.php';
	
	if ($email_gueltig == 0) {
		debug_to_console("Email-Adresse ist ungültig!");
		
		if($sprache=="deutsch") {
			$fehler ="Email-Adresse ist ungültig. Bitte geben Sie eine gültige Email-Adresse ein!";		
		}
		else {
			$fehler ="Invalid email adress. Please enter a valid email adress!";	
		}
		

		formausgeben($nachname, $vorname, $strasse, $plz,$ort,$land,$geb_datum, $geb_ort, $staatsbuergerschaft,$passnr,$email,$mobil_nummer_zu_hause,$mobil_nummer_vor_ort,$club,$oesv_nr,$shirt,$sponsor,$bootstype,$bootsname,$gruppen_fid,$tiefgang,$anzahl_crew,$unterschrieben,$eigene_rg_adresse,$rg_zeile1,$rg_zeile2,$rg_zeile3,$rg_zeile4,$fehler);
	} 
	else {
	//***********************************************************
	
	

	
	$neu_eintrag=1;
	include_once $_SERVER['DOCUMENT_ROOT'].'/gruppe_tn_eintrag_vorbereiten.php';
	
	//echo "<br> speichern_erlaubt: ".$speichern_erlaubt;
	if ($speichern_erlaubt ==0) {
		if($sprache=="deutsch") {
			$fehler ="In der ausgewählten Gruppe sind leider keine Boote mehr verfügbar. Bitte wählen Sie eine andere Gruppe aus. Auf unserer Startseite <br> &nbsp; <br>http://".$_SERVER['SERVER_NAME']."/startseite.php?regatta_id=".$regatta_id." <br>  &nbsp; <br> können Sie sich einen Überblick über freie Plätze verschaffen";
		}
		else {
			$fehler ="Unfortunately in the selected group there are no free boats any more. Please select an other group. On our site<br> &nbsp; <br>http://".$_SERVER['SERVER_NAME']."/startseite.php?regatta_id=".$regatta_id." <br>  &nbsp; <br> you can gain an overview of free places.";
		}
	}
	if (strlen($fehler) > 0) {
		formausgeben($nachname, $vorname, $strasse, $plz,$ort,$land,$geb_datum, $geb_ort, $staatsbuergerschaft,$passnr,$email,$mobil_nummer_zu_hause,$mobil_nummer_vor_ort,$club,$oesv_nr,$shirt,$sponsor,$bootstype,$bootsname,$gruppen_fid,$tiefgang,$anzahl_crew,$unterschrieben,$eigene_rg_adresse,$rg_zeile1,$rg_zeile2,$rg_zeile3,$rg_zeile4,$fehler);
	} 
	else {		
		if ($speichern_erlaubt==1) {
			//speichern ist erlaubt: Teilnehmer_Boot speichern
			 $sql="INSERT INTO tbl_teilnehmer_boot (regatta_fid,Nachname,Vorname,Strasse,PLZ,Ort,Land,Email,Club,Shirt,Sponsor,Bootstype,gruppen_fid,Anzahl_Crew,bootsname,tiefgang,mobil_nummer_zu_hause,mobil_nummer_vor_ort,oesv_nr,geb_datum,geb_ort,staatsbuergerschaft_Nr,passnr,unterschrieben,eigene_rg_adresse,rg_zeile1,rg_zeile2,rg_zeile3,rg_zeile4) ";
		 	$sql.="VALUES ('".$_GET['regatta_id']."','".$_POST['nachname']."','".$_POST['vorname']."','".$_POST['strasse']."','";
			 $sql.=$_POST['plz']."','".$_POST['ort']."','".$_POST['land']."','".$_POST['email']."','";
			 $sql.=$_POST['club']."','".$_POST['shirt']."','".$_POST['sponsor']."','".$_POST['bootstype']."','";
		 	$sql.=$_POST['gruppen_fid']."','".$_POST['anzahl_crew']."','".$_POST['bootsname']."','";
		 	$sql.=$_POST['tiefgang']."','".$_POST['mobil_nummer_zu_hause']."','".$_POST['mobil_nummer_vor_ort']."','";
		 	$sql.=$_POST['oesv_nr']."','".$_POST['geb_datum']."','".$_POST['geb_ort']."','";		 
		 	$sql.=$_POST['staatsbuergerschaft_Nr']."','".$_POST['passnr']."','".$_POST['unterschrieben']."','".$_POST['eigene_rg_adresse']."','".$_POST['rg_zeile1']."','".$_POST['rg_zeile2']."','".$_POST['rg_zeile3']."','".$_POST['rg_zeile4']."')";
			
			$statement = $mydb->prepare($sql);
			if ($statement->execute()) {}
			

			$teilnehmer_id = $mydb->lastInsertID();  //gibt jene ID zurück, die beim letzten Insert als Autoincrement-Wert vergeben wurde.
			
			$_SESSION['sess_login_teilnehmer_id']=$teilnehmer_id;
			
			if (!isset($_SESSION['sess_login_rechte']) OR ($_SESSION['sess_login_rechte']=="keine")) {
				$_SESSION['sess_login_rechte']="teilnehmer";
			}
			//include gruppe_suchen.php
			include_once $_SERVER['DOCUMENT_ROOT'].'/gruppe_suchen.php';
			
			//Ausgabe von gruppe_suchen: $gruppen_name
			
			//include vergebene_boote_aendern.php -->Anzahl der vergebenen Boote um 1 erhöhen
			$gruppe=$gruppen_name;
			$aktion="erhoehen";
			include_once $_SERVER['DOCUMENT_ROOT'].'/vergebene_boote_aendern.php';
			
			
			//Passwort erzeugen: die ersten 3 Buchstaben aus dem Regatta-Namen und danach eine 5-stellige Zufallsziffer zwischen 12537 und 93718)
		
			//regatta_suchen.php includieren. Wichtig:zuvor muss sichergestellt sein $sess_regatta_id zugewiesen ist. Das ist bereits vor dem Aufruf von
			//teilnehmer_eingabe.php gewährleistet!
			include $_SERVER['DOCUMENT_ROOT'].'/regatta_suchen.php';
			
			//jetzt kann ich auf $regatta_name und $regatta_kuerzel aus regatta_suchen.php zugreifen!
			$benutzername=$regatta_kuerzel.$_POST['email'];
		
			//benutzername erstellen. Besteht aus dem Regattakürzel und der Email-Adresse
			$_SESSION['sess_login_benutzername']=$benutzername;
			
	
			//die ersten drei Buchstaben für das Passwort erzeugen
			$passwort_teil1=substr($regatta_name,0,3);
			
			//die letzten 5 Stellen des Passworts erzeugen
			$zufallszahl=mt_rand();
			$passwort_teil2=substr($zufallszahl,0,5);
			
			//passwort zusammenfügen
			$passwort=$passwort_teil1.$passwort_teil2;			
			
			 $sql="INSERT INTO tbl_benutzerrechte (benutzername,passwort,rechte,teilnehmer_fid) ";
			 $sql.="VALUES ('".$benutzername."','".$passwort."','"."teilnehmer"."','".$teilnehmer_id."')";
			//echo("<br>".$sql);

			$skipper=$_POST['nachname']." ".$_POST['vorname'];
			
			
			$statement= $mydb->prepare($sql);
			if ($statement->execute()) {}
			
			include $_SERVER['DOCUMENT_ROOT'].'/regatta_suchen.php';

			
			//das muss genau einmal aufgerufen werden, wenn eine Email geschickt werden soll.
			$phpmailer=false;		//kennzeichnen, dass die Klasse phpmailer noch nicht angelegt wurde, daher wird sie
									//in email_versenden angelegt			
			
			$nur_einer=1;		//es soll nur die Rechnung eines einzelnen Teilnehmers gedruckt werden
			
			
			//Achtung: nur, wenn unverbindliche_Anmeldung=0 (also verbindlich), sollen Zugangsdaten und Rechnung
			//versendet werden. Dieser Fall ist allerdings der Standard. Nur ganz selten - wie z.b. 1000Meilen-Race2018
			//soll im Februar 2016 als unverbindlich angemeldet werden können.
			if ($unverbindliche_Anmeldung == 0) {
				//hier werden nur die Sprach-Variablen für Form-Verarbeiten definiert wie z.B. $message, ...
				if ($sprache == "deutsch") {
					$message='
						<?php
						header("Content-Type: text/html; charset=utf-8");
						?>
						<html>
						<head>
						<title>Zugangsdaten zur Aktualisierung Ihrer Meldung</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>
						<body>
						<table>
						<tr><td colspan="2">Liebe(r) Segler(in)!</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">Danke f&uuml;r die Anmeldung zu unserer Regatta <strong>'.utf8_decode($regatta_name).'</strong>.</td></tr>
						<tr><td colspan="2">Anbei senden wir Ihnen die Zugangsdaten, die Sie ben&ouml;tigen, wenn Sie Ihre Meldung aktualisieren wollen.</td></tr>
						<tr><td colspan="2">Bitte leiten Sie diese an Ihre Crewmitglieder weiter, damit Sie sich auch eintragen k&ouml;nnen.</td></tr>				
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td><strong>Zugangsdaten f&uuml;r Skipper : '.utf8_decode($skipper).'</strong></td></tr>
						<tr><td>Internet-Seite zur Aktualisierung: </td><td>'."http://".$_SERVER['SERVER_NAME'].'</td></tr>
						<tr><td>Benutzername: </td><td>'.utf8_decode($benutzername).'</td></tr>
						<tr><td>Pa&szlig;wort: </td><td>'.utf8_decode($passwort).'</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">Mit freundlichen Gr&uuml;&szlig;en</td></tr>
						<tr><td colspan="2">Ihr Xabel-Yachting-Team</td></tr>
						</table>
						</body>
						</html>';	
						
					$message_plain_text='
						Liebe(r) Segler(in)! \r\n
						Danke f&uuml;r die Anmeldung zu unserer Regatta <strong>'.utf8_decode($regatta_name).'</strong>.\r\n
						Anbei senden wir Ihnen die Zugangsdaten, die Sie ben&ouml;tigen, wenn Sie Ihre Meldung aktualisieren wollen.\r\n
						Bitte leiten Sie diese an Ihre Crewmitglieder weiter, damit Sie sich auch eintragen k&ouml;nnen.\r\n			
						\r\n
						<strong>Zugangsdaten f&uuml;r Skipper : '.utf8_decode($skipper).'</strong>\r\n
						Internet-Seite zur Aktualisierung: '."http://".$_SERVER['SERVER_NAME'].'\r\n
						Benutzername: '.utf8_decode($benutzername).'\r\n
						Pa&szlig;wort: '.utf8_decode($passwort).'\r\n
						\r\n
						Mit freundlichen Gr&uuml;&szlig;en\r\n
						Ihr Xabel-Yachting-Team
						';
					
					
					
					
					//Betreff-Zeile der Email
					//$restzahlungen_verschickt stammt aus regatta_suchen()
					debug_to_console("restzahlungen_verschickt: ".$restzahlungen_verschickt);
					if ($restzahlungen_verschickt ==0) {
						$subject=utf8_decode($regatta_name)." - Zugangsdaten und Anzahlungsrechnung";
					}
					else {
						$subject=utf8_decode($regatta_name)." - Zugangsdaten";
					}
				}
				else {
					$message='
						<?php
						header("Content-Type: text/html; charset=utf-8");
						?>
						<html>
						<head>
						<title>Username and password to update your registration</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>
						<body>
						<table>
						<tr><td colspan="2">Dear sailor!</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">Thank you for registering to our regatta <strong>'.utf8_decode($regatta_name).'</strong>.</td></tr>
						<tr><td colspan="2">To this message we have attached username and password, which you need, if you would like to update your registration.</td></tr>
						<tr><td colspan="2">Please pass username and password on to your crew members, so that they also can enter their data.</td></tr>				
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td><strong>Access data for skipper: '.utf8_decode($skipper).'</strong></td></tr>
						<tr><td>Website: </td><td>'."http://".$_SERVER['SERVER_NAME'].'</td></tr>
						<tr><td>User name: </td><td>'.utf8_decode($benutzername).'</td></tr>
						<tr><td>Password: </td><td>'.utf8_decode($passwort).'</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">With best regards</td></tr>
						<tr><td colspan="2">Your Xabel-Yachting-Team</td></tr>
						</table>
						</body>
						</html>';
						
					$message_plain_text='
						Dear sailor! \r\n
						Thank you for registering to our regatta <strong>'.utf8_decode($regatta_name).'</strong>.\r\n
						To this message we have attached username and password, which you need, if you would like to update your registration.\r\n
						Please pass username and password on to your crew members, so that they also can enter their data.\r\n			
						\r\n
						<strong>Access data for skipper: '.utf8_decode($skipper).'</strong>\r\n
						Website: '."http://".$_SERVER['SERVER_NAME'].'\r\n
						User name: '.utf8_decode($benutzername).'\r\n
						Password: '.utf8_decode($passwort).'\r\n
						\r\n
						With best regards\r\n
						Your Xabel-Yachting-Team
						';
					
					//Betreff-Zeile der Email
					//$restzahlungen_verschickt stammt aus regatta_suchen()
					debug_to_console("restzahlungen_verschickt: ".$restzahlungen_verschickt);
					if ($restzahlungen_verschickt == 0) {
						$subject=utf8_decode($regatta_name)." - Access data and first payment";
					}
					else {
						$subject=utf8_decode($regatta_name)." - Access data";
					}
				
				}	//Ende if sprache==
	
	
	
				if ($restzahlungen_verschickt == 0) {
					//Restzahlungen wurden für diese Regatta noch  nicht verschickt, daher alles ganz normal:
					//Anzahlung erstellen und verschicken
										//********************************************************************************
										//Variablen für rechnung_pfd.php initialisieren		
										$rg_nr=$letzte_rg_nr+1;

										$betreff="Anmeldung zur Regatta ".$regatta_name;
										//$rechnungs_art --> "rechnung" oder "gutschrift"
										//$gutschrift_text_drucken --> true (1) / false (0)
										$rechnungs_art="rechnung";		//Rechnung oder Gutschrift?
										$gutschrift_text_drucken=false;
										$anzahlung=true;
										//$teilnehmer_id ist an dieser Stelle bereits bekannt
										//Angaben zur ersten Rechnungsposition
										$z1_menge=1;
										$z1_pos="Anzahlung";
										$z1_betrag=$anzahlungshoehe;

										//Angaben zur zweiten Rechnungsposition			
										$z2=false;
										$z2_menge=8;
										$z2_pos="Nenngeld / Person";
										$z2_betrag=0;

										//Angaben zur dritten Rechnungsposition
										$z3=false;
										$z3_menge=1;
										$z3_pos="geleistete Anzahlung";
										$z3_betrag=0;

										//Angaben zur vierten Rechnungsposition
										$z4=false;
										$z4_menge=1;
										$z4_pos="Gutschrift";
										$z4_betrag=0;

										//Angaben zur 5. Rechnungsposition (Summen-Zeile)
										$z5_pos="Gesamt";
										$z5_betrag=$z1_betrag+$z2_betrag+$z3_betrag+$z4_betrag;	
										//$z5_betrag=500+1840-500-300;		
										//ENDE - Variablen für rechnung_pdf.php
										//********************************************************************************

										

										//mit rechnung_pdf.php wird die Rechnung erstellt und unter $datei_name (inkl. Pfad) am Server abgespeichert
										include_once $_SERVER['DOCUMENT_ROOT'].'/rechnung_pdf.php';			

										//***************************************
										//Rechnungsdaten müssen hier in tbl_rechnungen eingetragen werden!
										//$teilnehmer_id --> wurde weiter oben schon vergeben
										$rechnungs_nummer=$rg_gesamt;
										$rechnungs_datum=date("Y-m-d");
										$rechnungs_betrag=$z5_betrag;
										$pfad="rechnungen";
										$datei_name=$rechnungs_nummer.".pdf";

					
										$rg_art="Anzahlung";
										include_once $_SERVER['DOCUMENT_ROOT'].'/rechnung_insert.php';			
										//****************************************

					
										//Datein_name wieder so ändern, dass der Pfad inkludiert ist
										$datei_name="";
										$datei_name.="rechnungen/";
										$datei_name.=$rechnungs_nummer.".pdf";			

										$attachment=$datei_name;	//$datei_name stammt aus rechnung_pdf.php	
					
										//Email an den Teilnehmer mit Zugangsdaten und Anzahlungsrechnung versenden
										include $_SERVER['DOCUMENT_ROOT'].'/email_versenden.php';

				}	//Ende if restzahlungen_verschickt==0
				else {
					//restzahlungen_verschickt == 1
					//Restzahlungen wurden schon verschickt
					
					
					//Zugangsdaten an Teilnehmer senden (OHNE Attachment)
					include $_SERVER['DOCUMENT_ROOT'].'/email_versenden.php';
					
					
					
					//rechnung_aufruf.php erstellt eine Abschlussrechnung, also eine Restzahlung für diesen Teilnehmer, ohne vorher eine Anzahlung zu erstellen.
					//diese Rechnung wird an Iris geschickt (NICHT an den Teilnehmer), damit sie die Rechnung kontrolliert. Danach geht Iris ins System und schickt die Rechnung
					//manuell an den Teilnehmer
					//sollte mit der Rechnung etwas nicht in Ordnung sein, so muss Iris das manuell korrigieren. Achtung: das aktualisierte PDF muss den gleichen Namen haben wie das ursprüngliche!
					$rg_art="Restzahlung";
					include_once $_SERVER['DOCUMENT_ROOT'].'/rechnung_aufruf.php';	
					
					
					
					//*******************************************************************************************************************
					//Email PLUS Rechnung an Iris schicken
					//********************************************************************************************************************
					//$email enthält hier die Email-Adresse des Teilnehmers. Der soll aber keine Email erhalten, daher überschreibe ich hier die Variable mit Iris' Email-Adresse
					//dadurch erhält nur sie die Email
					
					//$email = "markus@gmail.com";
					$email = "iris@Xabel-yachting.com";
					
					//Betreff ändern, damit Iris gleich auffällt, dass sie die Rechnung kontrollieren und manuell an den Teilnehmer senden muss
					$subject="Zur Kontrolle und manuellen Versendung der Rechnung an den Teilnehmer - Anmeldung zur Regatta ".$regatta_name;
					
					
					//Datein_name wieder so ändern, dass der Pfad inkludiert ist
					$datei_name="";
					$datei_name.="rechnungen/";
					$datei_name.=$rechnungs_nummer.".pdf";			

					$attachment=$datei_name;	//$datei_name stammt aus rechnung_pdf.php	

					//Email an den Teilnehmer mit Zugangsdaten und Anzahlungsrechnung versenden
					include $_SERVER['DOCUMENT_ROOT'].'/email_versenden.php';					
				}	//Ende else restzahlungen_verschickt==1
			
	
			}	//Ende if ($unverbindliche_Anmeldung == 0)
			else {
				// hier kommt der Code für unverbindliche Anmeldung rein:
				//KEINE Zugangsdaten
				//KEINE Rechnung erstellen
				//andere//hier werden nur die Sprach-Variablen für Form-Verarbeiten definiert wie z.B. $message, ...
				if ($sprache == "deutsch") {
					$message='
						<?php
						header("Content-Type: text/html; charset=utf-8");
						?>
						<html>
						<head>
						<title>Danke f&uuml;r Ihre unverbindliche Anmeldung zu '.utf8_decode($regatta_name).'</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>
						<body>
						<table>
						<tr><td colspan="2">Lieber Teilnehmer!,</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						</table>
						</body>
						</html>';	
						
					$message_plain_text='
						Lieber Skipper, \r\n
						vielen Dank f&uuml;r die unverbindliche Anmeldung zu unserer Regatta <strong>';
					//Betreff-Zeile der Email
					$subject=utf8_decode($regatta_name)." - Ihre unverbindliche Anmeldung";	
				}
				else {
					$message='
						<?php
						header("Content-Type: text/html; charset=utf-8");
						?>
						<html>
						<head>
						<title>Your non-binding registration to '.utf8_decode($regatta_name).'</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>
						<body>
						<table>
						<tr><td colspan="2">Dear skipper,</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">thank you for registering (non-binding) to our regatta <strong>'.utf8_decode($regatta_name).'</strong>.</td></tr>
						</table>
						</body>
						</html>';
						
					$message_plain_text='
						Dear skipper, \r\n
						';
				//Betreff-Zeile der Email
				$subject=utf8_decode($regatta_name)." - your non-binding registration";
				}	//$sprache ==
				
				
				//Versenden der Erst-Email bei unverbindlicher Anmeldung
				include $_SERVER['DOCUMENT_ROOT'].'/email_versenden.php';
			}	//unverbindliche_Anmeldung ==
			

			
			
			
			
			//Beginn Update ersteEmailAnTnOk und ersteEmailAnXabelOk
			//sql-Statement erstellen
			$sql="UPDATE tbl_teilnehmer_boot ";
			$sql.="SET ersteEmailAnTnOk=".$email_an_teilnehmer.",ersteEmailAnXabelOk=".$versendet." ";	
			$sql.="WHERE teilnehmer_id=".$teilnehmer_id;

			$statement = $mydb->prepare($sql);
			if ($statement->execute()) {}
			//Ende Update ersteEmailAnTnOk und ersteEmailAnXabelOk 
			
			
			
		switch ($_SESSION['sess_login_rechte'])
		{
			case "administrator":
				Header("location:http://".$_SERVER['SERVER_NAME']."/teilnehmer_admin_administrator.php?teilnehmer_id=$teilnehmer_id&erst_aufruf=1");	
				break;
			case "teilnehmer":
				Header("location:http://".$_SERVER['SERVER_NAME']."/teilnehmer_admin_teilnehmer.php?teilnehmer_id=$teilnehmer_id&erst_aufruf=1");	
				break;
			default:
				Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
				break;
			
		}		//ende switch
	//header("location: teilnehmer_admin_teilnehmer.php?teilnehmer_id=$teilnehmer_id&erst_aufruf=1");
	} 	//ende if speichern_elaubt

  } 
	}
}	//Ende formverarbeiten

function formausgeben($nachname= "", $vorname ="", $strasse = "", $plz="",$ort="",$land="",$geb_datum="", $geb_ort="", $staatsbuergerschaft_Nr=0,$passnr="",$email="",$mobil_nummer_zu_hause="",$mobil_nummer_vor_ort="",$club="",$oesv_nr="",$shirt="",$sponsor="",$bootstype="",$bootsname="",$gruppen_fid=0,$tiefgang="",$anzahl_crew="",$unterschrieben=0,$eigene_rg_adresse=0,$rg_zeile1="",$rg_zeile2="",$rg_zeile3="",$rg_zeile4="",$fehler="") 
{
	global $regatta_id;
	global $sprache;
	global $unverbindliche_Anmeldung;
	
	if ($sprache == "deutsch") {
		//Variablen;
		$title = "Meldung eingeben";
		$button_speichern = "Speichern";
		$button_teilnehmerliste ="Meldeliste";
		$a_nachname = "Nachname";
		$a_vorname = "Vorname";
		$a_adresse_des_skippers = "Adresse des Skippers";
		$a_strasse ="Strasse";
		$a_plz ="PLZ";
		$a_ort = "Ort";
		$a_land = "Land";
		$a_zeile1 = "Zeile 1";
		$a_zeile2 = "Zeile 2";
		$a_zeile3 = "Zeile 3";
		$a_zeile4 = "Zeile 4";
		
		//Die Option Bitte verwenden Sie ... muss in zwei Teile aufgeteilt werden, weil der 2. Teil fettgedruckt werden soll.
		$a_bitte_verwenden_Sie_folgende = "Bitte verwenden Sie folgende ";
		$a_rechnungs_adresse = "Rechnungsadresse<br>(nur ausf&uuml;llen, wenn anders als Skipper-Adresse)";
				
		$a_email = "Email";
		$a_shirt_groesse = "Shirt-Gr&ouml;ße";
		$a_mobil_nummer_zu_hause = "Mobil-Nummer zu Hause";
		$a_mobil_nummer_vor_ort = "Mobil-Nummer vor Ort";
		$a_geburts_datum ="Geburtsdatum (yyyy-mm-tt)";
		$a_geburtsort = "Geburtsort";
		$a_staatsbuergerschaft = "Staatsb&uuml;rgerschaft";
		$a_pass_nummer = "Pass-Nummer";
		$a_club = "Club";
		$a_oesv_nr = "&Ouml;SV-Nr.";
		$a_anzahl_crew = "Anzahl der Crew-Mitglieder inkl. Skipper";
		$a_sponsor = "Sponsor";
		$a_bootstype = "Bootstype";
		$a_bootsname = "Bootsname";
		$a_gruppe ="Gruppe";
		$a_tiefgang = "Tiefgang";
		$a_offene_klasse_mit_spi = "offene Klasse mit Spi";
		$a_offene_klasse_ohne_spi ="offene Klasse ohne Spi";
	}
	else {
		//Variablen
		$title = "Enter to the regatta";		
		$button_speichern = "Save";
		$button_teilnehmerliste ="Entry List";
		$a_nachname = "Last name";
		$a_vorname = "First name";
		$a_adresse_des_skippers = "Skipper's address";
		$a_strasse ="Street";
		$a_plz ="ZIP";
		$a_ort = "City";
		$a_land = "Country";
		$a_zeile1 = "Row 1";
		$a_zeile2 = "Row 2";
		$a_zeile3 = "Row 3";
		$a_zeile4 = "Row 4";
		
		//Die Option Bitte verwenden Sie ... muss in zwei Teile aufgeteilt werden, weil der 2. Teil fettgedruckt werden soll.
		$a_bitte_verwenden_Sie_folgende = "Please use following ";
		$a_rechnungs_adresse = "billing adress<br>(only fill out if it is different to skipper's adress)";
		
		$a_email = "Email";
		$a_shirt_groesse = "Size of shirt";
		$a_mobil_nummer_zu_hause = "Mobile number at home";
		$a_mobil_nummer_vor_ort = "Mobile number during the event";
		$a_geburts_datum ="Date of birth (yyyy-mm-tt)";
		$a_geburtsort = "Birthplace";
		$a_staatsbuergerschaft = "Nationality";
		$a_pass_nummer = "Passport number";
		$a_club = "Club";
		$a_oesv_nr = "Membership number in club";
		$a_anzahl_crew = "Number of crew members including skipper";
		$a_sponsor = "Sponsor";
		$a_bootstype = "Type of boat";
		$a_bootsname = "Name of boat";
		$a_gruppe ="Group";
		$a_tiefgang = "Draft";	
		$a_offene_klasse_mit_spi = "open class with spi";
		$a_offene_klasse_ohne_spi ="open class without spi";	
	}


		
	?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		
	<title><?php echo $title;?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php';?>
	<style type="text/css">
    	.fehler { color: red; font-weight: bold; font-size: 16px;}
    </style>
		
	<link href="/CSS/normalize.css" rel="stylesheet">
	<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">

<!--	<script src="/functions.js" type="text/javascript"></script> -->	
	<script src="/functions.js" type="text/javascript"></script>
	
	
			
	
	<script type="text/javascript">
    	
	
    function function_eigene_rg_adresse() {
        document.teilnehmer_eingabe.eigene_rg_adresse.checked=1;
    }
				
	//KEINE unverbindliche Anmeldung, also umfangreiche Überprüfung der Eingaben durchführen
	function checkForm()
	{
		//var unverbindliche_Anmeldung=1;
		var errmsg="";
		var err_unterschreiben;
		var err_nachname;
		var err_vorname;
		var err_strasse;
		var err_plz;
		var err_ort;
		var err_land;
		var err_email;
		var err_bootstype;
		var err_gruppe;
		var err_anz_crew;
		var err_email_gueltig;


		//je nach Sprache die verschiedenen Fehlermeldungen auf deutsch oder englisch setzen
		if (document.teilnehmer_eingabe.sprache.value == "deutsch") {
			err_unterschreiben = "\n Bitte erklären Sie sich mit den Haftungs- und Datenschutzbestimmungen einverstanden!";
			err_nachname = "\n Bitte Nachname des Skippers eingeben!";
			err_vorname = "\n Bitte Vornamen des Skippers eingeben!";
			err_strasse = "\n Bitte Strasse des Skippers eingeben!";
			err_plz = "\n Bitte PLZ des Skippers eingeben!";
			err_ort = "\n Bitte Ort des Skippers eingeben!";
			err_land ="\n Bitte Land des Skippers eingeben!";
			err_email = "\n Bitte Email des Skippers eingeben!";
			err_bootstype ="\n Bitte Bootstype eingeben!";
			err_gruppe = "\n Bitte eine Gruppe auswählen!";
			err_anz_crew = "\n Bitte die Anzahl der Crewmitglieder (inkl. Skipper) eingeben!";
			err_email_gueltig ="\n Bitte gültige Email-Adresse eingeben!";
		}
		else {
			err_unterschreiben = "\n Pleace agree to the regulations concerning data protection and liability!";
			err_nachname = "\n Please enter skipper's last name!";
			err_vorname = "\n Please enter skipper's first name!";
			err_strasse ="\n Please enter skipper's street!";
			err_plz = "\n Please enter skipper's ZIP Code!";
			err_ort = "\n Please enter skipper's city!";
			err_land ="\n Please enter skipper's country!";
			err_email = "\n Please enter skipper's email address!";
			err_bootstype ="\n Please enter the type of your boat!";
			err_gruppe = "\n Please chose a group!";
			err_anz_crew = "\n Please enter the number of crew members including skipper!";
			err_email_gueltig ="\n Please enter a valid email address!";
		}

		
		if (document.teilnehmer_eingabe.unverbindliche_Anmeldung.value == 0) 
		{	
			//es handelt sich um eine VERBINDLICHE Anmeldung --> alles überprüfen

			if (document.teilnehmer_eingabe.unterschrieben.checked == 0)
			{
				 errmsg=err_unterschreiben;
				 document.teilnehmer_eingabe.unterschrieben.focus();
				 alert(errmsg);
				 return false;
			}

			var zeile1 = document.teilnehmer_eingabe.rg_zeile1.value;
			var zeile2 = document.teilnehmer_eingabe.rg_zeile2.value;
			var zeile3 = document.teilnehmer_eingabe.rg_zeile3.value;
			var zeile4 = document.teilnehmer_eingabe.rg_zeile4.value;

			var zeile_summe=zeile1+zeile2+zeile3+zeile4;
			if (leerer_text(zeile_summe)==true) {
				document.teilnehmer_eingabe.eigene_rg_adresse.checked=0;
			}

			if (document.teilnehmer_eingabe.nachname.value == "")
			{
				 errmsg=err_nachname;
				 document.teilnehmer_eingabe.nachname.focus();
				 alert(errmsg);
				 return false;
			}
			
			if (document.teilnehmer_eingabe.vorname.value == "")
			{
					errmsg += err_vorname;
					document.teilnehmer_eingabe.vorname.focus();
					alert(errmsg);
					return false;
			}
	
			if (document.teilnehmer_eingabe.strasse.value == "")
			{
				 errmsg=err_strasse;
				 document.teilnehmer_eingabe.strasse.focus();
				 alert(errmsg);
				 return false;
			}
	
			if (document.teilnehmer_eingabe.plz.value == "")
			{
				 errmsg=err_plz;
				 document.teilnehmer_eingabe.plz.focus();
				 alert(errmsg);
				 return false;
			}
	
			if (document.teilnehmer_eingabe.ort.value == "")
			{
				 errmsg= err_ort;
				 document.teilnehmer_eingabe.ort.focus();
				 alert(errmsg);
				 return false;
			}
	
			if (document.teilnehmer_eingabe.land.value == "")
			{
				 errmsg=err_land;
				 document.teilnehmer_eingabe.land.focus();
				 alert(errmsg);
				 return false;
			}
	
			if (document.teilnehmer_eingabe.email.value == "")
			{
				 errmsg=err_email;
				 document.teilnehmer_eingabe.email.focus();
				 alert(errmsg);
				 return false;
			}
			
	
			if (document.teilnehmer_eingabe.email.value!="")
			{
				var emd=document.teilnehmer_eingabe.email.value;
	
				if ((emd.indexOf("@")==-1) || (emd.indexOf(".") ==-1) || (emd.indexOf("@") > emd.lastIndexOf(".")) || (emd.lastIndexOf(".") > (emd.length-3)))
				{
					 errmsg= err_email_gueltig;
					 alert(errmsg);
					 return false;
				}
			}			
	
			if (document.teilnehmer_eingabe.bootstype.value == "")
			{
				 errmsg=err_bootstype;
				 document.teilnehmer_eingabe.bootstype.focus();
				 alert(errmsg);
				 return false;
			}
			
			if (document.teilnehmer_eingabe.gruppen_fid.value == 0)
			{
				 errmsg=err_gruppe;
				 document.teilnehmer_eingabe.gruppen_fid.focus();
				 alert(errmsg);
				 return false;
			}		
	
			if ((document.teilnehmer_eingabe.anzahl_crew.value == "") || (isNaN(document.teilnehmer_eingabe.anzahl_crew.value)==true) || (document.teilnehmer_eingabe.anzahl_crew.value <= 1))
			{
				 errmsg=err_anz_crew;
				 document.teilnehmer_eingabe.anzahl_crew.focus();
				 alert(errmsg);
				 return false;
			}				
	
			if (document.teilnehmer_eingabe.email.value!="")
			{
				var emd=document.teilnehmer_eingabe.email.value;
	
				if ((emd.indexOf("@")==-1) || (emd.indexOf(".") ==-1) || (emd.indexOf("@") > emd.lastIndexOf(".")) || (emd.lastIndexOf(".") > (emd.length-3)))
				{
					 errmsg= err_email_gueltig;
					 alert(errmsg);
					 return false;
				}
			}
	
			return true;
		}	//ENDE if (unverbindliche_Anmeldung == 0)
		else 
		{
			//UNVERBINDLICHE Anmeldung, also KEINE umfangreiche Überprüfung der Eingaben durchführen	
			
					
			if (document.teilnehmer_eingabe.nachname.value == "")
			{
				 errmsg=err_nachname;
				 document.teilnehmer_eingabe.nachname.focus();
				 alert(errmsg);
				 return false;
			}
			
			if (document.teilnehmer_eingabe.vorname.value == "")
			{
					errmsg += err_vorname;
					document.teilnehmer_eingabe.vorname.focus();
					alert(errmsg);
					return false;
			}
			
			if (document.teilnehmer_eingabe.email.value == "")
			{
				 errmsg=err_email;
				 document.teilnehmer_eingabe.email.focus();
				 alert(errmsg);
				 return false;
			}
			
			if (document.teilnehmer_eingabe.gruppen_fid.value == 0)
			{
				 errmsg=err_gruppe;
				 document.teilnehmer_eingabe.gruppen_fid.focus();
				 alert(errmsg);
				 return false;
			}
			
			if (document.teilnehmer_eingabe.email.value!="")
			{
				var emd=document.teilnehmer_eingabe.email.value;
	
				if ((emd.indexOf("@")==-1) || (emd.indexOf(".") ==-1) || (emd.indexOf("@") > emd.lastIndexOf(".")) || (emd.lastIndexOf(".") > (emd.length-3)))
				{
					 errmsg= err_email_gueltig;
					 alert(errmsg);
					 return false;
				}
			}
	
			return true;
		}	//Ende else
	}	//Ende  function checkform()
	
	</script>
	</head>	
		
	<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php'; ?>
	
	<div id="content">

	<?php

	$action="";
	//war speichern erlaubt? Falls ja teilnehmer_admin öffnen, sonst nochmals teilnehmer-Eingaben
	//je nachdem, ob $_SESSION['sess_login_rechte'] = 'administrator' oder teilnehmer die teilnehmer_admin_teilnehmer.php
	//oder die teilnehmer_admin_administrator.php aufrufen
	if ($speichern_erlaubt ==1) {
		if ($_SESSION['sess_login_rechte']=='administrator') {
			$action = "/teilnehmer_admin_administrator.php";
		}
		else {
			$action = "/teilnehmer_admin_teilnehmer.php";	
		}
		$action.="?teilnehmer_id=";
		$action.=$teilnehmer_id;
		$action.="&erst_aufruf=1";	
	}
	else {
		//speichern nicht erlaubt, daher nochmals die teilnehmer_eingabe öffnen
		$action = htmlspecialchars($_SERVER["PHP_SELF"]);
		$action.="?regatta_id=";
		$action.=$_GET['regatta_id'];				
	}
	//echo "<br> action: ".$action;
 	?>
	<form method="post" onSubmit="return checkForm()" action="<?php echo $action; ?>" name="teilnehmer_eingabe">
		
	
		
	<table cellpadding="5" cellspacing="0">
    <tr><td colspan=3 align="left"><h1><?php echo $title;?></h1></td><td><input type="hidden" name="sprache"value="<?php echo $sprache; ?>"></td><td><input type="hidden" name="unverbindliche_Anmeldung" value="<?php echo $unverbindliche_Anmeldung; ?>"></td></tr>
		
	<?php 
	if (!empty($fehler)) {
  	?>
		<tr><td colspan="2" class="fehler"><?php echo $fehler;?></td></tr>
	<?php
	}
	?>
		
	</table>
		
			
	<div id="formular">	
		
	<section class="formular-articles">

		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_nachname; ?>:</td>
				<td><input type="text" name="nachname" value="<?php echo $nachname; ?>"></td>
			  </tr>
			</table>
		</article>

		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_vorname; ?>:</td>
				<td><input type="text" name="vorname" value="<?php echo $vorname; ?>"></td>
			  </tr>
			</table>
		</article>	
	
	</section>
		
		
	<section class="formular-articles">
		<article class="box formular adresse">
		  <table>
			  <tr>
				  <td><strong><?php echo $a_adresse_des_skippers;?>:</strong></td>
				  <td>&nbsp;</td>
			  </tr>
			  <tr>
				  <td><?php echo $a_strasse; ?>:</td>
			      <td><input type="text" name="strasse"  value="<?php echo $strasse; ?>"></td>
			  </tr>
			  <tr>
				  <td><?php echo $a_plz; ?>:</td>
			      <td><input type="text" name="plz"  value="<?php echo $plz; ?>"></td>
			  </tr>
			  <tr>
				  <td><?php echo $a_ort; ?>:</td>
		       	  <td><input type="text" name="ort"  value="<?php echo $ort; ?>"></td>
			  </tr>
			  <tr>
				  <td><?php echo $a_land; ?>:</td>
			      <td><input type="text" name="land"  value="<?php echo $land; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular adresse">
		  <table>
			  <tr>
				  <td colspan="2">
					<?php
						if ($eigene_rg_adresse==1) {
						//angekreuzt
						echo "<input type='checkbox' name='eigene_rg_adresse' value='1' checked> ";

						}
						else {
						//nicht angekreuzt
						echo "<input type='checkbox' name='eigene_rg_adresse' value='1'> ";				 
						}
					?>                                
					<?php echo $a_bitte_verwenden_Sie_folgende; ?> <strong><?php echo $a_rechnungs_adresse; ?></strong>. 
					<?php
					include $_SERVER['DOCUMENT_ROOT'].'/rechnungsadresse_popup_oeffnen.php';
					?>                              
				  </td>
			  </tr>
			  <tr>
				  <td><?php echo $a_zeile1; ?>:</td>
			      <td><input type="text" onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile1"  value="<?php echo $rg_zeile1; ?>"></td>
			  </tr>
			  <tr>
				  <td><?php echo $a_zeile2; ?>:</td>
			      <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile2"   value="<?php echo $rg_zeile2; ?>"></td>
			  </tr>
			  <tr>
				  <td ><?php echo $a_zeile3; ?>:</td>
			      <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile3"   value="<?php echo $rg_zeile3; ?>"></td>
			  </tr>
			  <tr>
				  <td ><?php echo $a_zeile4; ?>:</td>
				  <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile4"   value="<?php echo $rg_zeile4; ?>"></td>
			  </tr>
			</table>
		</article>	
	</section>
		
		
		
		
		
		
		
		
	<!--- das ist der Formular-Teil unterhalb der Adress-Blöcke  --->
	<section class="formular-articles">

		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_email; ?>:</td>
				<td><input type="text" name="email"   value="<?php echo $email; ?>"></td>
			  </tr>
			</table>
		</article>

		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_shirt_groesse; ?>:</td>
				<td>
			  		<select size="1" name="shirt" class="select50">
                
					<?php 
					$shirt_h=$shirt;
					include $_SERVER['DOCUMENT_ROOT'].'/feld_shirt_aufbauen.php';
					?>  
			  	</td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_mobil_nummer_zu_hause; ?>:</td>
				<td><input type="text" name="mobil_nummer_zu_hause"   value="<?php echo $mobil_nummer_zu_hause; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_mobil_nummer_vor_ort; ?>:</td>
				<td><input type="text" name="mobil_nummer_vor_ort"   value="<?php echo $mobil_nummer_vor_ort; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_geburts_datum; ?>:</td>
				<td><input type="text" name="geb_datum"   value="<?php echo $geb_datum; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_geburtsort; ?>:</td>
				<td><input type="text" name="geb_ort"   value="<?php echo $geb_ort; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_staatsbuergerschaft; ?>:</td>
				<td>
				  	<select name="staatsbuergerschaft_Nr"  class="select100">
					<?php
					//options füllen
					//connection.php includieren
					include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

					if ($sprache == "deutsch")
					{	
						$sql="SELECT Nation_Nr,Nation_Name_deutsch FROM tbl_nationen ";
						$sql.="ORDER BY Nation_Name_deutsch";

						$statement = $mydb->prepare($sql);
						if ($statement->execute()) {}					

						//Recordset durchwandern, und die Gruppen in die Liste speichern
						while ($akt_zeile=$statement->fetch()) {	

						   echo "<option value='".$akt_zeile["Nation_Nr"]."' ";
						   if ($akt_zeile["Nation_Nr"]==$staatsbuergerschaft_Nr)
						   {						   
								echo " selected";
						   }

							echo ">".$akt_zeile["Nation_Name_deutsch"];
							echo "</option>";				   
						}
					}
					else
					{
						$sql="SELECT Nation_Nr,Nation_Name_englisch FROM tbl_nationen ";
						$sql.="ORDER BY Nation_Name_englisch";

						$statement = $mydb->prepare($sql);
						if ($statement->execute()) {}					

						//Recordset durchwandern, und die Gruppen in die Liste speichern
						while ($akt_zeile=$statement->fetch()) {	

						   echo "<option value='".$akt_zeile["Nation_Nr"]."' ";
						   if ($akt_zeile["Nation_Nr"]==$staatsbuergerschaft_Nr)
						   {						   
								echo " selected";
						   }

							echo ">".$akt_zeile["Nation_Name_englisch"];
							echo "</option>";				   
						}					
					}

				   echo "<option value='0' ";
						if ($Nation_Nr==0) {
							echo "selected";
						}
				   echo "></option>";
					?>
					</select>
			  	</td>
			  </tr>
			</table>
		</article>			
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_pass_nummer; ?>:</td>
				<td><input type="text" name="passnr"   value="<?php echo $passnr; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_club; ?>:</td>
				<td><input type="text" name="club"   value="<?php echo $club; ?>"></td>
			  </tr>
			</table>
		</article>			
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_oesv_nr; ?>:</td>
				<td><input type="text" name="oesv_nr"   value="<?php echo $oesv_nr; ?>"></td>
			  </tr>
			</table>
		</article>			
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_anzahl_crew; ?>:</td>
				<td><input type="text" name="anzahl_crew" size="10"  value="<?php echo $anzahl_crew; ?>"></td>
			  </tr>
			</table>
		</article>			
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_sponsor; ?>:</td>
				<td><input type="text" name="sponsor"   value="<?php echo $sponsor; ?>"></td>
			  </tr>
			</table>
		</article>		

		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_bootstype; ?>:</td>
				<td><input type="text" name="bootstype"   value="<?php echo $bootstype; ?>"></td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_bootsname; ?>:</td>
				<td><input type="text" name="bootsname"   value="<?php echo $bootsname; ?>"></td>
			  </tr>
			</table>
		</article>			
		
		<article class="box formular">
		  <table>
			  <tr>
				<td>
					<?php echo $a_gruppe; ?> (<?php include $_SERVER['DOCUMENT_ROOT'].'/freie_plaetze_popup_oeffnen_neu.php'; ?>):
			  	</td>
				<td>
				  
					<select size=1 name="gruppen_fid" class="select100">
					<?php
					//options füllen
					//connection.php includieren
					include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

					$sql="SELECT gruppen_id,regatta_fid, Gruppe FROM tbl_gruppe ";
					$sql.="WHERE (regatta_fid=".$_SESSION['sess_regatta_id'].") ";
					$sql.="ORDER BY Gruppe";

					$statement = $mydb->prepare($sql);
					if ($statement->execute()){}

					//Recordset durchwandern, und die Gruppen in die Liste speichern
					while ($akt_zeile=$statement->fetch()) {

					   echo "<option value='".$akt_zeile["gruppen_id"]."' ";
					   if ($akt_zeile["gruppen_id"]==$gruppen_fid)
							   {						   
							   echo " selected";
							   }


					   //wenn $akt_zeile["Gruppe"] == "offene Klasse mit Spi" oder "offene Klasse ohne Spie", so sollen, 
					   //je nach Sprachauswahl deutsche oder englische Listenelemente angezeigt werden
					   if ($akt_zeile["Gruppe"]=="offene Klasse mit Spi") {
							echo ">".$a_offene_klasse_mit_spi;
					   }
					   else if ($akt_zeile["Gruppe"]=="offene Klasse ohne Spi"){
							echo ">".$a_offene_klasse_ohne_spi;
					   }
					   else {			   
							echo ">".$akt_zeile["Gruppe"];
					   }



					   echo "</option>";				   
				   }
				   echo "<option value='0' ";
						//echo "<br> gruppen_fid: ".$gruppen_fid; 
						if ($gruppen_fid==0) {
							echo "selected";
						}
				   echo "></option>";
					?>
					</select>
					
			  	</td>
			  </tr>
			</table>
		</article>	
		
		<article class="box formular">
		  <table>
			  <tr>
				<td><?php echo $a_tiefgang; ?>:</td>
				<td><input type="text" name="tiefgang"   value="<?php echo $tiefgang; ?>"></td>
			  </tr>
			</table>
		</article>		
		

		<article class="box formular">
		  <table>
			  <tr>
				<td colspan="2"><?php
					 if ($unterschrieben==1) {
						//angekreuzt
						echo "<input type='checkbox' name='unterschrieben' value='1' checked> ";
						
					 }
					 else {
						//nicht angekreuzt
						echo "<input type='checkbox' name='unterschrieben' value='1'> ";				 
					 }
                						 
					include $_SERVER['DOCUMENT_ROOT'].'/disclaimer_popup_oeffnen.php'; 
					?>
			  	</td>
			  </tr>
			</table>
		</article>		
		
	</section>

	</div> <!-- div id=formular-->
	</div>   <!--  div id=content -->
	

		
		
		
		
		
		
	<!-------------------------------------------------------------------------->
	<!-- Beginn Navigationsbuttons --------------------------------------------->
	<section class="navi-articles">
		
		
		<article class="box navi">
			<table align="center">
			<tr>
				<td>
					<input type="submit" name="gesendet" value="<?php echo $button_speichern; ?>">
				</td>
			</tr>
	  		</form> 
			</table>
		</article>
		
		<article class="box navi">
			<table align="center">
				<tr>
					<td>
						<?php
						//herausfinden, wohin der Button teilnehmerliste zeigen soll: auf teilnehmerliste.php (sess_login_rechte="administrator) oder teilnehmerliste_lesen.php (sess_login_rechte"teilnehmer" oder "keine"
						if ($_SESSION['sess_login_rechte']=="administrator") {
							$action="/teilnehmerliste.php?regatta_id=".$_SESSION['sess_regatta_id'];
						}
						else
						{
							$action="/teilnehmerliste_lesen.php?regatta_id=".$_SESSION['sess_regatta_id'];
						} 
						?>            
						<form  class="navi_hoehe" method="post" action=<?php echo $action; ?> name="teilnehmerliste">
						<input type="submit" name="teilnehmerliste" value="<?php echo $button_teilnehmerliste; ?>">
						</form>
					</td>

				</tr>
			</table>
		</article>
		
	</section>
		
<?php    
}	//Ende Function formausgeben()

debug_to_console("Ende teilnehmer_eingabe.php");
?>

</body>
</html>