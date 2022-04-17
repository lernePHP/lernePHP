<?php
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//hierher wird nur verzeigt, wenn eine neue Regatta eingegeben wurde, Regatta_Nr ist ein Auto_increment-Feld und muss daher nicht eingegeben werden
if ($_POST['speichern']=="Speichern") {
		//echo "Restzahlung fällig bis: ".$_POST['restzahlung_faellig_bis'];
        //es wurde auf SPEICHERN gedrückt
        //überprüfung der Daten erfolgte bereits auf der vorigen Seite
		$sql="INSERT INTO tbl_regatta (Regatta_Name,regatta_kuerzel,damen_shirts,kornati_cup, Regatta_Beginn,Regatta_Ende, Kosten_Boot, Kosten_Person, Kosten_erm_Boot, Fruehzahler_Datum, restzahlung_faellig_bis, Disclaimer, Disclaimer_englisch, Veranstaltungslogo, Anzahlungshoehe,offene_klasse_mit_spi, offene_klasse_ohne_spi) ";
		$sql.="VALUES ('".$_POST['Regatta_Name']."','".$_POST['regatta_kuerzel']."','".$_POST['damen_shirts']."','".$_POST['kornati_cup']."','".$_POST['Regatta_Beginn']."','".$_POST['Regatta_Ende']."','".$_POST['Kosten_Boot']."','".$_POST['Kosten_Person']."','".$_POST['Kosten_erm_Boot']."','".$_POST['Fruehzahler_Datum']."','".$_POST['restzahlung_faellig_bis']."','".$_POST['Disclaimer']."','".$_POST['Disclaimer_englisch']."','".$_POST['Veranstaltungslogo']."','".$_POST['Anzahlungshoehe']."','".$_POST['offene_klasse_mit_spi']."','".$_POST['offene_klasse_ohne_spi']."')";
	
		$statement = $mydb -> prepare($sql);
		if ($statement->execute()) {}
		
		$regatta_id=$mydb->lastInsertId();	//gibt den letzten vergebenen Autoincrement-Wert zurück
	
	
	
	
		$sql_ins="INSERT INTO tbl_gruppen_bestand (regatta_fid,gruppe,max_verfuegbar,vergeben) ";
	   	$sql_ins.="VALUES ('".$regatta_id."','offene Klasse mit und ohne Spi','0','0')";
	
		$statement_ins = $mydb -> prepare($sql_ins);
		if ($statement_ins->execute()) {}
		
		if ($_POST['offene_klasse_mit_spi']==1) {
			//Gruppe offene Klasse mit Spi in tbl_Gruppe eintragen
			$sql_ins="INSERT INTO tbl_gruppe (regatta_fid,Gruppe) ";
	   		$sql_ins.="VALUES ('".$regatta_id."','offene Klasse mit Spi')";
	
			$statement_ins = $mydb -> prepare($sql_ins);
			if ($statement_ins->execute()) {}
		}
		
		if ($_POST['offene_klasse_ohne_spi']==1) {
			//Gruppe offene Klasse mit Spi in tbl_Gruppe eintragen
			$sql_ins="INSERT INTO tbl_gruppe (regatta_fid,Gruppe) ";
	   		$sql_ins.="VALUES ('".$regatta_id."','offene Klasse ohne Spi')";
			
			$statement_ins = $mydb -> prepare($sql_ins);
			if ($statement_ins->execute()) {}
		}
		
}

Header("location:http://".$_SERVER['SERVER_NAME']."/regattaliste.php");

?>