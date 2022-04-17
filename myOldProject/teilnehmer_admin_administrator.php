<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in teilnehmer_admin_administrator.php");



//******************************************************************************
//Eingang:	teilnehmer_id
//			erst_aufruf		TRUE bzw. 1, wenn diese Datei das erste Mal aufgerufen wird, FALSE, falls die Datei bereits einmal aufgerufen wurde
//******************************************************************************
header("Content-Type: text/html; charset=utf-8");
session_start();		//damit ich auf sess_regatta_id zugreifen kann und teilnehmer_id als session- Variable definieren kann...
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//echo "<br>sess_regatta_id: ".$sess_regatta_id."<br>";
//ab hier ist die aktuelle regatta_id mittels Session-Variable sess_regatta_id verfügbar
//die sess_regatta_id wurde beim Laden der teilnehmerliste.php definiert

//wenn keine id (sprich teilnehmer-ID)übergeben wurde, dann "stirb"
if (!$_GET['teilnehmer_id']) die;

$_SESSION['sess_teilnehmer_id']=$_GET['teilnehmer_id'];
$teilnehmer_id=$_GET['teilnehmer_id'];
$regatta_id = $_SESSION['sess_regatta_id'];
$sprache = $_SESSION['sprache'];

If ($_SESSION['sess_login_rechte'] !="administrator")
{
	//keine Berechtigung
	Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
}

if ($_GET['erst_aufruf'] == 1) {
	//echo "<br> erst_aufruf: ".$_GET['erst_aufruf'];
	//übergebenen Teilnehmer selektieren und die Werte in die Variablen speichern
	          //sql-Statement erstellen
	$sql="SELECT regatta_fid,nenngeld_befreiung,Barzahlung,restzahlung_verschickt,Nachname,Vorname,Strasse,PLZ,Ort,Land,Email,Club,Shirt,Sponsor,Bootstype,gruppen_fid,Anzahl_Crew, ";
	$sql.="ersteEmailAnTnOk, ersteEmailAnXabelOk, ersteEmailAnTnFehlerBehoben,ersteEmailAnXabelFehlerBehoben, ";
	$sql.="bootsname,tiefgang,mobil_nummer_zu_hause,mobil_nummer_vor_ort,oesv_nr,geb_datum,geb_ort,staatsbuergerschaft_Nr, ";
	$sql.="passnr,unterschrieben,eigene_rg_adresse,rg_zeile1,rg_zeile2,rg_zeile3,rg_zeile4 ";
	$sql.="FROM tbl_teilnehmer_boot ";
	$sql.="WHERE teilnehmer_id=".$_SESSION['sess_teilnehmer_id'];
	//echo $sql;
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
	
	
	//Recordset durchwandern,Daten ins Formular eintragen
	while ($akt_zeile=$statement->fetch()) {
		//formausgeben($nachname_h, $vorname_h, $strasse_h, $plz_h,$ort_h,$land_h,$geb_datum_h, $geb_ort_h, $staatsbuergerschaft_h,$passnr_h,$email_h,$mobil_nummer_zu_hause_h,,$club_h,$oesv_nr_h,$shirt_h,$sponsor_h,$bootstype_h,$bootsname_h,$gruppen_fid_h,$tiefgang_h,$anzahl_crew_h,$fehler);
		
		//Achtung: ich darf diese Variablen nicht gleich nennen, wie in teilnehmer_suchen. 
		//Denn später wird teilnehmer_suchen aufgerufen und die Variablen würden dann dort mit falschen 
		//(den vorher abgespeicherten Werten) überschrieben werden.
		//daher nehme ich statt $nachname $nachname_h statt $nachname ...
		
		$nenngeld_befreiung_h=$akt_zeile["nenngeld_befreiung"];
		$barzahlung_h=$akt_zeile["Barzahlung"];	
		$restzahlung_verschickt_h=$akt_zeile["restzahlung_verschickt"];
		$nachname_h=$akt_zeile["Nachname"];
		$vorname_h=$akt_zeile["Vorname"];
		$strasse_h=$akt_zeile["Strasse"];
		$plz_h=$akt_zeile["PLZ"];
		$ort_h=$akt_zeile["Ort"];
		$land_h=$akt_zeile["Land"];
		$geb_datum_h=$akt_zeile["geb_datum"];
		$geb_ort_h=$akt_zeile["geb_ort"];		
		$staatsbuergerschaft_Nr_h=$akt_zeile["staatsbuergerschaft_Nr"];
		$passnr_h=$akt_zeile["passnr"];
		$email_h=$akt_zeile["Email"];
		$mobil_nummer_zu_hause_h=$akt_zeile["mobil_nummer_zu_hause"];
		$mobil_nummer_vor_ort_h=$akt_zeile["mobil_nummer_vor_ort"];
		$club_h=$akt_zeile["Club"];
		$oesv_nr_h=$akt_zeile["oesv_nr"];
		$shirt_h=$akt_zeile["Shirt"];
		$sponsor_h=$akt_zeile["Sponsor"];
		$bootstype_h=$akt_zeile["Bootstype"];
		$bootsname_h=$akt_zeile["bootsname"];
		$gruppen_fid_h=$akt_zeile["gruppen_fid"];
		$tiefgang_h=$akt_zeile["tiefgang"];
		$anzahl_crew_h=$akt_zeile["Anzahl_Crew"];
		$unterschrieben_h=$akt_zeile["unterschrieben"];	
		$eigene_rg_adresse_h=	$akt_zeile["eigene_rg_adresse"];	
		$rg_zeile1_h=	$akt_zeile["rg_zeile1"];	
		$rg_zeile2_h=	$akt_zeile["rg_zeile2"];	
		$rg_zeile3_h=	$akt_zeile["rg_zeile3"];	
		$rg_zeile4_h=	$akt_zeile["rg_zeile4"];		
		//ersteEmailAnTnOk, ersteEmailAnXabelOk, ersteEmailAnTnFehlerBehoben,ersteEmailAnXabelFehlerBehoben
		$_SESSION['sess_ersteEmailAnTnOk'] = $akt_zeile["ersteEmailAnTnOk"];
		$_SESSION['sess_ersteEmailAnXabelOk'] = $akt_zeile["ersteEmailAnXabelOk"];
		$_SESSION['sess_ersteEmailAnTnFehlerBehoben'] = $akt_zeile["ersteEmailAnTnFehlerBehoben"];
		$_SESSION['sess_ersteEmailAnXabelFehlerBehoben'] = $akt_zeile["ersteEmailAnXabelFehlerBehoben"];	
		$fehler="";	
	}	//ENDE while
}	//ENDE if ($erst_aufruf == 1)

//echo "<br>speichern: ".$_POST['speichern'];
//echo "<br>isset speichern: ".$_POST['speichern'];
if (isset($_POST["speichern"])) {
  formverarbeiten();
  //echo "<br>isset speichern: ".$_POST['speichern'];
  //echo "<br>form_gruppen_fid: ".$_POST['gruppen_fid'];
  //echo "<br>\$gruppen_fid_h: ".$gruppen_fid_h;  
} 
else {
	//echo "<br>speichern: ".$_POST['speichern'];
	formausgeben($nenngeld_befreiung_h,$barzahlung_h,$restzahlung_verschickt_h,$nachname_h, $vorname_h, $strasse_h, $plz_h,$ort_h,$land_h,$geb_datum_h, $geb_ort_h, $staatsbuergerschaft_Nr_h,$passnr_h,$email_h,$mobil_nummer_zu_hause_h,$mobil_nummer_vor_ort_h,$club_h,$oesv_nr_h,$shirt_h,$sponsor_h,$bootstype_h,$bootsname_h,$gruppen_fid_h,$tiefgang_h,$anzahl_crew_h,$unterschrieben_h,$eigene_rg_adresse_h,$rg_zeile1_h,$rg_zeile2_h,$rg_zeile3_h,$rg_zeile4_h,$fehler);
}

function formverarbeiten()
{
	//echo "<br>nachname: ".$_POST['nachname'];
	//echo "<br>vorname: ".$_POST['vorname'];
	//echo "<br> \$_POST['strasse']: ".$_POST['strasse'];	
  isset($_POST["nachname"]) && is_string($_POST["nachname"]) ? $nachname_h = trim($_POST["nachname"]) : $nachname_h= "";
  isset($_POST["vorname"])  && is_string($_POST["vorname"])  ? $vorname_h =  trim($_POST["vorname"]) : $vorname_h= "";
  isset($_POST["strasse"])  && is_string($_POST["strasse"])  ? $strasse_h =  trim($_POST["strasse"]) : $strasse_h= "";
  isset($_POST["plz"])  && is_string($_POST["plz"])  ? $plz_h =  trim($_POST["plz"]) : $plz_h= "";
  isset($_POST["ort"])  && is_string($_POST["ort"])  ? $ort_h =  trim($_POST["ort"]) : $ort_h= "";
  isset($_POST["land"])  && is_string($_POST["land"])  ? $land_h =  trim($_POST["land"]) : $land_h= "";
  isset($_POST["geb_datum"]) ? $geb_datum_h =  $_POST["geb_datum"] : $geb_datum_h= "";
  isset($_POST["geb_ort"])  && is_string($_POST["geb_ort"])  ? $geb_ort_h =  trim($_POST["geb_ort"]) : $geb_ort_h= "";
  isset($_POST["staatsbuergerschaft_Nr"])  ? $staatsbuergerschaft_Nr_h = $_POST["staatsbuergerschaft_Nr"] : $staatsbuergerschaft_Nr_h= 0;  
  isset($_POST["passnr"])  && is_string($_POST["passnr"])  ? $passnr_h =  trim($_POST["passnr"]) : $passnr_h= "";
  isset($_POST["email"])  && is_string($_POST["email"])  ? $email_h =  trim($_POST["email"]) : $email_h= "";  
  isset($_POST["mobil_nummer_zu_hause"])  && is_string($_POST["mobil_nummer_zu_hause"])  ? $mobil_nummer_zu_hause_h =  trim($_POST["mobil_nummer_zu_hause"]) : $mobil_nummer_zu_hause_h= "";  
  isset($_POST["mobil_nummer_vor_ort"])  && is_string($_POST["mobil_nummer_vor_ort"])  ? $mobil_nummer_vor_ort_h =  trim($_POST["mobil_nummer_vor_ort"]) : $mobil_nummer_vor_ort_h= "";  
  isset($_POST["club"])  && is_string($_POST["club"])  ? $club_h =  trim($_POST["club"]) : $club_h= "";
  isset($_POST["oesv_nr"])  ? $oesv_nr_h = $_POST["oesv_nr"] : $oesv_nr_h= "";
  isset($_POST["shirt"])  && is_string($_POST["shirt"])  ? $shirt_h =  trim($_POST["shirt"]) : $shirt_h= "";
  isset($_POST["sponsor"])  && is_string($_POST["sponsor"])  ? $sponsor_h =  trim($_POST["sponsor"]) : $sponsor_h= "";
  isset($_POST["bootstype"])  && is_string($_POST["bootstype"])  ? $bootstype_h =  trim($_POST["bootstype"]) : $bootstype_h= "";
  isset($_POST["bootsname"])  && is_string($_POST["bootsname"])  ? $bootsname_h =  trim($_POST["bootsname"]) : $bootsname_h= "";

  //echo "<br>gruppen_fid vor Zuweisung in formverarbeiten: ".$gruppen_fid_h;  
  isset($_POST["gruppen_fid"])  ? $gruppen_fid_h = $_POST["gruppen_fid"] : $gruppen_fid_h= 0;
  //echo "<br>gruppen_fid nach Zuweisung in formverarbeiten: ".$gruppen_fid_h;  
  
  
  isset($_POST["tiefgang"])  ? $tiefgang_h = $_POST["tiefgang"] : $tiefgang_h= "";
  isset($_POST["anzahl_crew"])  ? $anzahl_crew_h = $_POST["anzahl_crew"] : $anzahl_crew_h= "";

  if (isset($_POST["nenngeld_befreiung"])) {
  
	if ($_POST['nenngeld_befreiung']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$nenngeld_befreiung_h=1;	
	}
	else {
		$nenngeld_befreiung_h=0;
	}
  }
  else {
  	$nenngeld_befreiung_h=0;
  }	

  //*****************	
  if (isset($_POST["barzahlung"])) {
  
	if ($_POST['barzahlung']==1) {
		//echo "Barzahlung ist angehakt";
		$barzahlung_h=1;	
	}
	else {
		$barzahlung_h=0;
	}
  }
  else {
  	$barzahlung_h=0;
  }	
  //*****************

  //*****************	
  if (isset($_POST["restzahlung_verschickt"])) {
  
	if ($_POST['restzahlung_verschickt']==1) {
		//echo "Barzahlung ist angehakt";
		$restzahlung_verschickt_h=1;	
	}
	else {
		$restzahlung_verschickt_h=0;
	}
  }
  else {
  	$restzahlung_verschickt_h=0;
  }	
  //*****************	
	
	
	
  if (isset($_POST["unterschrieben"])) {
  
	if ($_POST['unterschrieben']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$unterschrieben_h=1;	
	}
	else {
		$unterschrieben_h=0;
	}
  }
  else {
  	$unterschrieben_h=0;
  }	
  
  if (isset($_POST["eigene_rg_adresse"])) {
  
	if ($_POST['eigene_rg_adresse']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$eigene_rg_adresse_h=1;	
	}
	else {
		$eigene_rg_adresse_h=0;
	}
  }
  else {
  	$eigene_rg_adresse_h=0;
  }	
  
  isset($_POST["rg_zeile1"])  && is_string($_POST["rg_zeile1"])  ? $rg_zeile1_h =  trim($_POST["rg_zeile1"]) : $rg_zeile1_h= "";
  isset($_POST["rg_zeile2"])  && is_string($_POST["rg_zeile2"])  ? $rg_zeile2_h =  trim($_POST["rg_zeile2"]) : $rg_zeile2_h= "";
  
  isset($_POST["rg_zeile3"])  && is_string($_POST["rg_zeile3"])  ? $rg_zeile3_h =  trim($_POST["rg_zeile3"]) : $rg_zeile3_h= "";
  isset($_POST["rg_zeile4"])  && is_string($_POST["rg_zeile4"])  ? $rg_zeile4_h =  trim($_POST["rg_zeile4"]) : $rg_zeile4_h= "";
	
  $fehler = "";
	
	//*********************************************************
	//email-Adresse gültig -> Überprüfung mittels externem Tool
	//dieses Tool überprüft nicht nur die Syntax, sondern, ob an diese Adresse tatsächlich Mails verschickt werden können
	$email=$email_h;
	include $_SERVER['DOCUMENT_ROOT'].'/email_adresse_pruefen.php';
	
	if ($email_gueltig == 0) {
		debug_to_console("Email-Adresse ist ungültig!");
		

		$fehler ="Email-Adresse ist ungültig. Bitte geben Sie eine gültige Email-Adresse ein!";		

			
		formausgeben($nenngeld_befreiung_h,$barzahlung_h,$restzahlung_verschickt_h,$nachname_h, $vorname_h, $strasse_h, $plz_h,$ort_h,$land_h,$geb_datum_h, $geb_ort_h, $staatsbuergerschaft_Nr_h,$passnr_h,$email_h,$mobil_nummer_zu_hause_h,$mobil_nummer_vor_ort_h,$club_h,$oesv_nr_h,$shirt_h,$sponsor_h,$bootstype_h,$bootsname_h,$gruppen_fid_h,$tiefgang_h,$anzahl_crew_h,$unterschrieben_h,$eigene_rg_adresse_h,$rg_zeile1_h,$rg_zeile2_h,$rg_zeile3_h,$rg_zeile4_h,$fehler);
	} 
	else {
	//***********************************************************		
	
	//überprüfen, ob die ausgewählte Gruppe noch freie Boote hat
	$regatta_id = $_SESSION['sess_regatta_id'];	
	$gruppen_id=$_POST['gruppen_fid'];
	$neu_eintrag=0;
	$teilnehmer_id=$_GET['teilnehmer_id'];
	//$teilnehmer_id ist auch schon weiter oben definiert
	
	include $_SERVER['DOCUMENT_ROOT'].'/gruppe_tn_eintrag_vorbereiten.php';
  
	//hierher kommt er schon nicht mehr ...
	//echo "<br>speichern erlaubt: ".$speichern_erlaubt;
	//echo "<br>bestand ändern: ".$sbestand_aendern;

	
	//echo "<br> speichern_erlaubt: ".$speichern_erlaubt;
	if ($speichern_erlaubt ==0) {

		$fehler ="In der ausgewählten Gruppe sind leider keine Boote mehr verfügbar. Bitte wählen Sie eine andere Gruppe aus. Auf unserer Startseite <br> &nbsp; <br>http://".$_SERVER['SERVER_NAME']."/startseite.php?regatta_id=".$regatta_id." <br>  &nbsp; <br> können Sie sich einen Überblick über freie Plätze verschaffen";

	}
	if (strlen($fehler) > 0) {
		//echo "<br> \$gruppen_fid_h nach Fehlerausgabe: ".$gruppen_fid_h;
			
			formausgeben($nenngeld_befreiung_h,$barzahlung_h,$restzahlung_verschickt_h,$nachname_h, $vorname_h, $strasse_h, $plz_h,$ort_h,$land_h,$geb_datum_h, $geb_ort_h, $staatsbuergerschaft_Nr_h,$passnr_h,$email_h,$mobil_nummer_zu_hause_h,$mobil_nummer_vor_ort_h,$club_h,$oesv_nr_h,$shirt_h,$sponsor_h,$bootstype_h,$bootsname_h,$gruppen_fid_h,$tiefgang_h,$anzahl_crew_h,$unterschrieben_h,$eigene_rg_adresse_h,$rg_zeile1_h,$rg_zeile2_h,$rg_zeile3_h,$rg_zeile4_h,$fehler);
	} 
	else {		
		if ($speichern_erlaubt==1) {
			//vor dem Speichern des Teilnehmers muss die "alte Gruppe gemerkt werden, 
			//damit der Bestand danach um 1 erhöht werden kann
			//das wurde allerdings indirekt schon über das INCLUDE von gruppe_tn_eintrag_vorbereitsn erledigt
			//hier wurde unter $gruppe_DB der Gruppen-Name der für den TN im Moment gespeicherten Gruppe gemerkt
		
			//speichern ist erlaubt --> UPDATE auf tbl_teilnehmer_boot
			
			//sql-Statement erstellen
			$sql="UPDATE tbl_teilnehmer_boot ";
			$sql.="SET nenngeld_befreiung='".$_POST['nenngeld_befreiung']."',barzahlung='".$_POST['barzahlung']."',restzahlung_verschickt='".$_POST['restzahlung_verschickt']."',nachname='".$_POST['nachname']."',vorname='".$_POST['vorname']."', ";
			$sql.="strasse='".$_POST['strasse']."',plz='".$_POST['plz']."',ort='".$_POST['ort']."', ";
			$sql.="land='".$_POST['land']."',email='".$_POST['email']."',club='".$_POST['club']."', ";
			$sql.="shirt='".$_POST['shirt']."',sponsor='".$_POST['sponsor']."',bootstype='".$_POST['bootstype']."', ";
			$sql.="gruppen_fid='".$_POST['gruppen_fid']."',Anzahl_Crew='".$_POST['anzahl_crew']."', ";
			$sql.="bootsname='".$_POST['bootsname']."',tiefgang='".$_POST['tiefgang']."', ";
			$sql.="mobil_nummer_zu_hause='".$_POST['mobil_nummer_zu_hause']."',mobil_nummer_vor_ort='".$_POST['mobil_nummer_vor_ort']."', ";
			$sql.="oesv_nr='".$_POST['oesv_nr']."',geb_datum='".$_POST['geb_datum']."', ";
			$sql.="geb_ort='".$_POST['geb_ort']."',staatsbuergerschaft_Nr='".$_POST['staatsbuergerschaft_Nr']."', ";
			
			$sql.="passnr='".$_POST['passnr']."',unterschrieben='".$_POST['unterschrieben']."',eigene_rg_adresse='".$_POST['eigene_rg_adresse']."',rg_zeile1='".$_POST['rg_zeile1']."',rg_zeile2='".$_POST['rg_zeile2']."',rg_zeile3='".$_POST['rg_zeile3']."',rg_zeile4='".$_POST['rg_zeile4']."' ";	
			$sql.="WHERE teilnehmer_id=".$_SESSION['sess_teilnehmer_id'];

			$statement = $mydb->prepare($sql);
			if($statement->execute()){}
			
			
			if ($bestand_aendern ==1) {
				//nur wenn $bestand_aendern==1, dann muss am Gruppenbestand etwas getan werden

				//************************************************
				//"alte" Gruppe freigeben
				//$regatta_id, $gruppe und $aktion als Eingang
				$gruppe=$gruppe_DB;
				$aktion="verringern";
				include $_SERVER['DOCUMENT_ROOT'].'/vergebene_boote_aendern.php';
				//ENDE - "alte" Gruppe freigeben
				//************************************************			
				
				//************************************************
				//"neue" Gruppe: 1 Boot mehr ist nun vergeben
				//include gruppe_suchen.php
				include $_SERVER['DOCUMENT_ROOT'].'/gruppe_suchen.php';	//Eingang: gruppen_id
				
				//Ausgabe von gruppe_suchen: $gruppen_name
				
				//include vergebene_boote_aendern.php -->Anzahl der vergebenen Boote um 1 erhöhen in der neuen Gruppe
				$gruppe=$gruppen_name;
				$aktion="erhoehen";
				include $_SERVER['DOCUMENT_ROOT'].'/vergebene_boote_aendern.php';
				//ENDE - "neue" Gruppe: 1 Boot mehr ist nun vergeben
				//************************************************
			}	//ENDE if ($bestand_aaendern == 1)
			
			formausgeben($nenngeld_befreiung_h,$barzahlung_h,$restzahlung_verschickt_h,$nachname_h, $vorname_h, $strasse_h, $plz_h,$ort_h,$land_h,$geb_datum_h, $geb_ort_h, $staatsbuergerschaft_Nr_h,$passnr_h,$email_h,$mobil_nummer_zu_hause_h,$mobil_nummer_vor_ort_h,$club_h,$oesv_nr_h,$shirt_h,$sponsor_h,$bootstype_h,$bootsname_h,$gruppen_fid_h,$tiefgang_h,$anzahl_crew_h,$unterschrieben_h,$eigene_rg_adresse_h,$rg_zeile1_h,$rg_zeile2_h,$rg_zeile3_h,$rg_zeile4_h,$fehler);
					
		} 	//ende if speichern_elaubt
		
		$action = htmlspecialchars($_SERVER["PHP_SELF"]);
		$action.="?teilnehmer_id=";
		$action.=$_SESSION['sess_teilnehmer_id'];  
		$action.="& erst_aufruf=0";
		
		//header("location: $action");
  } 
}
}	//Ende formverarbeiten

function formausgeben($nenngeld_befreiung_h=0,$barzahlung_h=0,$restzahlung_verschickt_h=0,$nachname_h= "", $vorname_h ="", $strasse_h = "", $plz_h="",$ort_h="",$land_h="",$geb_datum_h="", $geb_ort_h="", $staatsbuergerschaft_Nr_h="",$passnr_h="",$email_h="",$mobil_nummer_zu_hause_h="",$mobil_nummer_vor_ort_h="",$club_h="",$oesv_nr_h="",$shirt_h="",$sponsor_h="",$bootstype_h="",$bootsname_h="",$gruppen_fid_h=0,$tiefgang_h="",$anzahl_crew_h="",$unterschrieben_h=0,$eigene_rg_adresse_h=0,$rg_zeile1_h="",$rg_zeile2_h="",$rg_zeile3_h="",$rg_zeile4_h="",$fehler="") {
	
	global $regatta_id;
	global $sprache;

	
	if ($sprache == "deutsch") {
		//Variablen;
		$nenngeld_befreiung ="Nenngeld-Befreiung";
		$barzahlung = "Barzahlung";
		$restzahlung_verschickt="Restzahlung verschickt";
		$title = "Meldung verwalten";
		$button_speichern = "Speichern";
		$button_teilnehmerliste ="Meldeliste";
		$button_crewliste = "Crewliste";
		$button_zahlungsdetails = "Zahlungsdetails + Ratings";
		$button_gutschrift ="Gutschrift";
		$button_rechnung_eingeben ="Rechnung eingeben";
		$button_zur_rechnungsliste = "Zur Rechnungsliste";
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
		$a_rechnungs_adresse = "Rechnungsadresse (nur ausf&uuml;llen, wenn anders als Skipper-Adresse)";
		
		
		
		
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
		$nenngeld_befreiung ="Entry fee exemption";
		$barzahlung = "cash payment";
		$restzahlung_verschickt="Restzahlung verschickt";	
		$title = "Administrate your registration";		
		$button_speichern = "Save";
		$button_teilnehmerliste ="Entry List";
		$button_crewliste = "List of Crew Members";
		$button_zahlungsdetails = "Details of Payments + Ratings";
		$button_gutschrift ="credit";
		$button_rechnung_eingeben ="enter account";
		$button_zur_rechnungsliste = "List of Invoices";
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
		$a_rechnungs_adresse = "billing adress<br>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;(only fill out if it is different to skipper's adress)";
		
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
		
    <title><?php echo $title; ?></title>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>
    <style type="text/css">
    	.fehler { color: red; font-weight: bold; font-size: 16px;}
    </style>

		
	<link href="/CSS/normalize.css" rel="stylesheet">
	<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">		
		
    <script src="/functions.js" type="text/javascript"></script>
    <script language="JavaScript">
    <!--
	function function_eigene_rg_adresse() {
		document.teilnehmer_eingabe.eigene_rg_adresse.checked=1;
	}
	
    function checkForm()
    {
			/*
			In der Administrator-Sicht dieses Formulars soll außer Nachname, Vorname, Email und Gruppe nichts überprüft werden.
			*/
            var errmsg="";

			/*
			if (document.teilnehmer_eingabe.unterschrieben.checked == 0)
			{
				 errmsg="\n Bitte erklären Sie sich mit den Haftungs- und Datenschutzbestimmungen einverstanden!";
				 document.teilnehmer_eingabe.unterschrieben.focus();
				 alert(errmsg);
				 return false;
			}
			*/
			
			var zeile1 = document.teilnehmer_eingabe.rg_zeile1.value;
			var zeile2 = document.teilnehmer_eingabe.rg_zeile2.value;
			var zeile3 = document.teilnehmer_eingabe.rg_zeile3.value;
			var zeile4 = document.teilnehmer_eingabe.rg_zeile4.value;

			var zeile_summe=zeile1+zeile2+zeile3+zeile4;
			if (leerer_text(zeile_summe)==true) {
				document.teilnehmer_eingabe.eigene_rg_adresse.checked=0;
			}

            if (document.teilnehmer_eingabe.nachname.value==true)
            {
                 errmsg="\n Bitte Nachname des Skippers eingeben";
                 document.teilnehmer_eingabe.nachname.focus();
                 alert(errmsg);
                 return false;
            }
            
            if (document.teilnehmer_eingabe.vorname.value == true)
            {
                    errmsg += "\n Bitte Vornamen des Skippers eingeben";
                    document.teilnehmer_eingabe.vorname.focus();
                    alert(errmsg);
                    return false;
            }
    
			/*
            if (document.teilnehmer_eingabe.strasse.value == true)
            {
                 errmsg="\n Bitte Strasse des Skippers eingeben";
                 document.teilnehmer_eingabe.strasse.focus();
                 alert(errmsg);
                 return false;
            }
    
            if (document.teilnehmer_eingabe.plz.value == true)
            {
                 errmsg="\n Bitte PLZ des Skippers eingeben";
                 document.teilnehmer_eingabe.plz.focus();
                 alert(errmsg);
                 return false;
            }
    
            if (document.teilnehmer_eingabe.ort.value == true)
            {
                 errmsg="\n Bitte Ort des Skippers eingeben";
                 document.teilnehmer_eingabe.ort.focus();
                 alert(errmsg);
                 return false;
            }
    		
            if (document.teilnehmer_eingabe.land.value == true)
            {
                 errmsg="\n Bitte Land des Skippers eingeben";
                 document.teilnehmer_eingabe.land.focus();
                 alert(errmsg);
                 return false;
            }
    		*/
			
            if (document.teilnehmer_eingabe.email.value == true)
            {
                 errmsg="\n Bitte Email des Skippers eingeben";
                 document.teilnehmer_eingabe.email.focus();
                 alert(errmsg);
                 return false;
            }
    
			/*
            if (document.teilnehmer_eingabe.bootstype.value == true)
            {
                 errmsg="\n Bitte Bootstype eingeben";
                 document.teilnehmer_eingabe.bootstype.focus();
                 alert(errmsg);
                 return false;
            }
            */
			
            if (document.teilnehmer_eingabe.gruppen_fid.value == 0)
            {
                 errmsg="\n Bitte eine Gruppe auswählen!";
                 document.teilnehmer_eingabe.gruppen_fid.focus();
                 alert(errmsg);
                 return false;
            }		
    		
		
			
            if ((document.teilnehmer_eingabe.anzahl_crew.value == "") || (isNaN(document.teilnehmer_eingabe.anzahl_crew.value)==true) || (document.teilnehmer_eingabe.anzahl_crew.value <= 1))
            {
                 errmsg="\n Bitte die Anzahl der Crewmitglieder (inkl. Skipper) eingeben!";
                 document.teilnehmer_eingabe.anzahl_crew.focus();
                 alert(errmsg);
                 return false;
            }				
    		
			
            if (document.teilnehmer_eingabe.email.value!="")
            {
                var emd=document.teilnehmer_eingabe.email.value;
    
                if ((emd.indexOf("@")==-1) || (emd.indexOf(".") ==-1) || (emd.indexOf("@") > emd.lastIndexOf(".")) || (emd.lastIndexOf(".") > (emd.length-3)))
                {
                     errmsg="\n Bitte gültige Email-Adresse eingeben!";
                     alert(errmsg);
                     return false;
                }
            }
    
            return true;
    }
    //-->
    </script>
    </head>
    
    <body>
    <?php
    
    //******************************************
    include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php';
    ?>
    
	<div id="content">
   
	<?php	  		
	if (!empty($fehler)) {
    	echo "<p class='fehler'>$fehler</p>";
  	}

	$action = htmlspecialchars($_SERVER["PHP_SELF"]);
	$action.="?teilnehmer_id=";
	$action.=$_SESSION['sess_teilnehmer_id'];  
	$action.="& erst_aufruf=0";
	
	$emailFehlerSchreiben = 0;
	$emailFehlerNichtBekannt =0;
		
	if ($_GET['teilnehmer_id'] < 1000) {

		$emailFehlerNichtBekannt = 1;
	}
	
	if (((!$_SESSION['sess_ersteEmailAnTnOk']) && (!$_SESSION['sess_ersteEmailAnTnFehlerBehoben'])) || ((!$_SESSION['sess_ersteEmailAnXabelOk']) && (!$_SESSION['sess_ersteEmailAnXabelFehlerBehoben'])))
	{
		$emailFehlerSchreiben = 1;
	}
	
	?>
    
	<!------------------ Beginn der Formular-Felder --------------------------------->
	<form method="post" onSubmit="return checkForm()" action="<?php echo $action; ?>" name="teilnehmer_eingabe">		
		
	<table cellpadding="5" cellspacing="0">			
		
    	<tr><td colspan="5"><input type="hidden" name="sprache" value="<?php echo $sprache; ?>"></td></tr>
		<tr>
			<td align="left"><h1><?php echo $title;?></h1></td>
		</tr>
		
     <?php
	 // die Fehlermeldungen bei fehlerhaftem Erst-Emailversand unterscheiden sich geringfügig, je nach dem, ob der TN eine
	 //Nenngeldbefreiung hat oder nicht.
    if ($emailFehlerNichtBekannt) {?>   
		<tr>
			<td align="left" bgcolor="#CCCCCC">Es ist nicht bekannt, ob beim Versenden der Erst-Email inklusive Anzahlungsrechnung und Zugangsdaten ein Fehler aufgetreten ist.</td>
		</tr>	
    <?php
    }
	else if ($emailFehlerSchreiben) {
		if ($nenngeld_befreiung_h==1) {			//der TN hat eine Nenngeldbefreiung
		?>   
    		<tr>
                <td align="left" bgcolor="#FF0000">
                	Fehler beim Versenden der Erst-Email inklusive Zugangsdaten! <br>Wenden Sie sich bitte an Xabel Company!
                </td>
            </tr>
		<?php 
		}
		else			//TN hat KEINE Nenngeld-Befreiung
		{
		?>   
    		<tr>
                <td align="left" bgcolor="#FF0000">
                	Fehler beim Versenden der Erst-Email inklusive Anzahlungs-Rechnung und Zugangsdaten! <br>Wenden Sie sich bitte an Xabel Company!
                </td>
            </tr>
		<?php 			
		}
	}
	else {
		if ($nenngeld_befreiung_h==1) {			//der TN hat eine Nenngeldbefreiung
		?>
			<tr>
                <td align="left" bgcolor="#CCCCCC">Erst-Email-Versand OK. Zugangsdaten wurden erfolgreich zugestellt.</td>
            </tr>
        <?php 
		}
		else			//TN hat KEINE Nenngeld-Befreiung
		{
		?>   
    		<tr>
                <td align="left" bgcolor="#CCCCCC">
                	Erst-Email-Versand OK. Zugangsdaten und Anzahlungsrechnung wurden erfolgreich zugestellt.
                </td>
            </tr>
		<?php 			
		}            
	} 
	?>
	</table>
		
	

	<!------ Beginn des Box-Systems ------------------------> 
	<div id="formular">
		<section class="formular-articles">	
		
			<article class="box formular">
		  		<table>
					<tr>		
						<td>
							<?php
							 if ($nenngeld_befreiung_h==1) {
								//angekreuzt
								echo "<input type='checkbox' name='nenngeld_befreiung' value='1' checked disabled> ";

							 }
							 else {
								//nicht angekreuzt
								echo "<input type='checkbox' name='nenngeld_befreiung' value='1' disabled> ";				 
							 }
							 echo "Nenngeld-Befreiung";                           
							?>
						</td>
						<td>
							<?php
							 if ($barzahlung_h==1) {
								//angekreuzt
								echo "<input type='checkbox' name='barzahlung' value='1' checked> ";

							 }
							 else {
								//nicht angekreuzt
								echo "<input type='checkbox' name='barzahlung' value='1'> ";				 
							 }
							 echo "Barzahlung";                           
							?>
						</td>
					</tr>
				</table>
			</article>

			<!--- leerer article --->
			<article class="box formular">
			  <table>
				  <tr>
					<td>
						<?php
						 if ($restzahlung_verschickt_h==1) {
							//angekreuzt
							echo "<input type='checkbox' name='restzahlung_verschickt' value='1' checked> ";

						 }
						 else {
							//nicht angekreuzt
							echo "<input type='checkbox' name='restzahlung_verschickt' value='1'> ";				 
						 }
						 echo "Restzahlung verschickt";                           
						?>
					</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
			</article>
			<!----------------------->			

			
			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_nachname; ?>:</td>
					<td><input type="text" name="nachname" value="<?php echo $nachname_h; ?>"></td>
				  </tr>
				</table>
			</article>

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_vorname; ?>:</td>
					<td><input type="text" name="vorname" value="<?php echo $vorname_h; ?>"></td>
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
					  <td><input type="text" name="strasse"  value="<?php echo $strasse_h; ?>"></td>
				  </tr>
				  <tr>
					  <td><?php echo $a_plz; ?>:</td>
					  <td><input type="text" name="plz"  value="<?php echo $plz_h; ?>"></td>
				  </tr>
				  <tr>
					  <td><?php echo $a_ort; ?>:</td>
					  <td><input type="text" name="ort"  value="<?php echo $ort_h; ?>"></td>
				  </tr>
				  <tr>
					  <td><?php echo $a_land; ?>:</td>
					  <td><input type="text" name="land"  value="<?php echo $land_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular adresse">
			  <table>
				  <tr>
					  <td colspan="2">
						<?php
							if ($eigene_rg_adresse_h==1) {
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
					  <td><input type="text" onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile1"  value="<?php echo $rg_zeile1_h; ?>"></td>
				  </tr>
				  <tr>
					  <td><?php echo $a_zeile2; ?>:</td>
					  <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile2"   value="<?php echo $rg_zeile2_h; ?>"></td>
				  </tr>
				  <tr>
					  <td ><?php echo $a_zeile3; ?>:</td>
					  <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile3"   value="<?php echo $rg_zeile3_h; ?>"></td>
				  </tr>
				  <tr>
					  <td ><?php echo $a_zeile4; ?>:</td>
					  <td ><input type="text"  onClick="function_eigene_rg_adresse()" onChange="function_eigene_rg_adresse()" name="rg_zeile4"   value="<?php echo $rg_zeile4_h; ?>"></td>
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
					<td><input type="text" name="email"   value="<?php echo $email_h; ?>"></td>
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
					<td><input type="text" name="mobil_nummer_zu_hause"   value="<?php echo $mobil_nummer_zu_hause_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_mobil_nummer_vor_ort; ?>:</td>
					<td><input type="text" name="mobil_nummer_vor_ort"   value="<?php echo $mobil_nummer_vor_ort_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_geburts_datum; ?>:</td>
					<td><input type="text" name="geb_datum"   value="<?php echo $geb_datum_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_geburtsort; ?>:</td>
					<td><input type="text" name="geb_ort"   value="<?php echo $geb_ort_h; ?>"></td>
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
							   if ($akt_zeile["Nation_Nr"]==$staatsbuergerschaft_Nr_h)
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
							   if ($akt_zeile["Nation_Nr"]==$staatsbuergerschaft_Nr_h)
							   {						   
									echo " selected";
							   }

								echo ">".$akt_zeile["Nation_Name_englisch"];
								echo "</option>";				   
							}					
						}

					   echo "<option value='0' ";
							if ($staatsbuergerschaft_Nr_h==0) {
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
					<td><input type="text" name="passnr"   value="<?php echo $passnr_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_club; ?>:</td>
					<td><input type="text" name="club"   value="<?php echo $club_h; ?>"></td>
				  </tr>
				</table>
			</article>			

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_oesv_nr; ?>:</td>
					<td><input type="text" name="oesv_nr"   value="<?php echo $oesv_nr_h; ?>"></td>
				  </tr>
				</table>
			</article>			

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_anzahl_crew; ?>:</td>
					<td><input type="text" name="anzahl_crew" size="10"  value="<?php echo $anzahl_crew_h; ?>"></td>
				  </tr>
				</table>
			</article>			

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_sponsor; ?>:</td>
					<td><input type="text" name="sponsor"   value="<?php echo $sponsor_h; ?>"></td>
				  </tr>
				</table>
			</article>		

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_bootstype; ?>:</td>
					<td><input type="text" name="bootstype"   value="<?php echo $bootstype_h; ?>"></td>
				  </tr>
				</table>
			</article>	

			<article class="box formular">
			  <table>
				  <tr>
					<td><?php echo $a_bootsname; ?>:</td>
					<td><input type="text" name="bootsname"   value="<?php echo $bootsname_h; ?>"></td>
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
						   if ($akt_zeile["gruppen_id"]==$gruppen_fid_h)
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
							if ($gruppen_fid_h==0) {
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
					<td><input type="text" name="tiefgang"   value="<?php echo $tiefgang_h; ?>"></td>
				  </tr>
				</table>
			</article>		


			<article class="box formular">
			  <table>
				  <tr>
					<td colspan="2"><?php
						 if ($unterschrieben_h==1) {
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

        			<td><input type="submit" name="speichern" value="<?php echo $button_speichern; ?>">
					</td>
					</form>
        		</tr>
				</table>
			</article>
		
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/teilnehmerliste.php?regatta_id=<?php echo $_SESSION['sess_regatta_id'];?>" name="teilnehmerliste">
					<td>
						<input type="submit" name="teilnehmerliste" value="<?php echo $button_teilnehmerliste; ?>">
					</td>
					</form>
				</tr>
				</table>
			</article>	
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/crewliste.php?teilnehmer_id=<?php echo $_SESSION['sess_teilnehmer_id'];?>" name="crewliste">
			        <td><input type="submit" name="crewliste" value="<?php echo $button_crewliste; ?>">
					</td>
					</form>
				</tr>
				</table>
			</article>	
                    
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/zahlungsdetails.php?teilnehmer_id=<?php echo $_SESSION['sess_teilnehmer_id'];?>" name="zahlungsdetails_lesen">
        			<td><input type="submit" name="zahlungsdetails" value="<?php echo $button_zahlungsdetails;?>">
					</td>
					</form>
				</tr>
				</table>
			</article>			
		
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/gutschrift_eingeben_aufruf.php?teilnehmer_id=<?php echo $_SESSION['sess_teilnehmer_id'];?>" name="gutschrift_eingeben_aufruf">
        			<td><input type="submit" name="gutschrift" value="<?php echo $button_gutschrift;?>">
					</td>
					</form>
				</tr>
				</table>
			</article>		
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/rechnung_eingeben.php?teilnehmer_id=<?php echo $_SESSION['sess_teilnehmer_id'];?>" name="rechnung_eingeben">
        			<td><input type="submit" name="rechnung_eingeben" value="<?php echo $button_rechnung_eingeben;?>">
					</td>
					</form>
				</tr>
				</table>
			</article>			
		
			<article class="box navi">
				<table align="center">
				<tr>
					<form class="navi_hoehe" method="post" action="/rechnungs_liste_administrator.php?teilnehmer_id=<?php echo $_SESSION['sess_teilnehmer_id'];?>" name="rechnungs_liste">
        			<td><input type="submit" name="rechnungs_liste" value="<?php echo $button_zur_rechnungsliste; ?>">
					</td>
					</form>
				</tr>
				</table>
			</article>			
		</section>
<?php
}	//ENDE function formausgeben()

debug_to_console("Ende teilnehmer_admin_administrator.php");
?>
</body>
</html>