<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
//debug_to_console("Hallo in regatta_admin");		//Achtung! Funktioniert nur, 
													//wenn die Header-Anweisungen auskommentiert werden!


header("Content-Type: text/html; charset=utf-8");
//Session-Variable für regatta_id definieren

//wenn keine id (sprich Regatta-ID)übergeben wurde, dann "stirb"

if (!$_GET['regatta_id']) die;
session_start();
$_SESSION['sess_regatta_id']=$_GET['regatta_id'];
$regatta_id=$_GET['regatta_id'];
?>
<html>
<head>
<title>Verwalten einer Regatta</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>

			
<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
<script src="/functions.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function checkForm()
{
        var errmsg="";
        if (document.speichern.Regatta_Name.value == "")
        {
                errmsg += "\n Bitte Regatta-Name eingeben";
                document.speichern.Regatta_Name.focus();
                alert(errmsg);
                return false;
        }

        if (document.speichern.regatta_kuerzel.value == "")
        {
                errmsg += "\n Bitte Regatta-Kürzel eingeben";
                document.speichern.regatta_kuerzel.focus();
                alert(errmsg);
                return false;
        }

        if (document.speichern.Regatta_Beginn.value == "")
        {
             errmsg="\n Bitte Regatta_Beginn eingeben";
             document.speichern.Regatta_Beginn.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.speichern.Regatta_Beginn.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für den Regatta_Beginn eintragen";
                        document.speichern.Regatta_Beginn.focus();
                        alert(errmsg);
                        return false;
                        }

                if (document.speichern.Regatta_Ende.value == "")
        {
             errmsg="\n Bitte Regatta_Ende eingeben";
             document.speichern.Regatta_Ende.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.speichern.Regatta_Ende.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für das Regatta_Ende eintragen";
                        document.speichern.Regatta_Ende.focus();
                        alert(errmsg);
                        return false;
                        }

                //überprüfen, ob das Ende-Datum nach dem Anfangsdatum liegt
                if (document.speichern.Regatta_Beginn.value>document.speichern.Regatta_Ende.value)
                        {
                        errmsg="\n Regatta-Beginn liegt nach dem Regatta-Ende";
                        document.speichern.Regatta_Ende.focus();
                        alert(errmsg);
                        return false;
                        }
		if (document.speichern.Kosten_Boot.value == "")
        {
                errmsg += "\n Bitte die Kosten für das Veranstaltungspackage pro Boot eingeben";
                document.speichern.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Kosten_Boot.value <0)
        {
                errmsg += "\n Die Kosten für das Veranstaltungspackage pro Boot können nicht negativ sein!";
                document.speichern.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Kosten_Person.value == "")
        {
                errmsg += "\n Bitte die Kosten für das Veranstaltungspackage pro Person eingeben";
                document.speichern.Kosten_Person.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Kosten_Person.value <0)
        {
                errmsg += "\n Die Kosten für das Veranstaltungspackage pro Person können nicht negativ sein!";
                document.speichern.Kosten_Person.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Kosten_erm_Boot.value == "")
        {
                errmsg += "\n Bitte die Kosten für das ermäßigte Package pro Boot eingeben";
                document.speichern.Kosten_erm_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Kosten_erm_Boot.value <0)
        {
                errmsg += "\n Die Kosten für das ermäßigte Package pro Boot können nicht negativ sein!";
                document.speichern.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.speichern.Fruehzahler_Datum.value == "")
        {
             errmsg="\n Bitte das Frühzahler-Datum eingeben";
             document.speichern.Fruehzahler_Datum.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.speichern.Fruehzahler_Datum.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für das Frühzahler-Datum eintragen";
                        document.speichern.Fruehzahler_Datum.focus();
                        alert(errmsg);
                        return false;
                        }

		if (document.speichern.restzahlung_faellig_bis.value == "")
        {
             errmsg="\n Bitte ein Fälligkeitsdatum für die Restzahlung eingeben";
             document.speichern.restzahlung_faellig_bis.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.speichern.restzahlung_faellig_bis.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Fälligkeitsdatum für die Restzahlung eingeben";
                        document.speichern.restzahlung_faellig_bis.focus();
                        alert(errmsg);
                        return false;
                        }
		
		if (document.speichern.Anzahlungshoehe.value == "")
        {
             errmsg="\n Bitte die Höhe der Anzhahlung eingeben";
             document.speichern.Anzahlungshoehe.focus();
             alert(errmsg);
             return false;
        }
		
		if (document.speichern.Anzahlungshoehe.value <0)
        {
             errmsg="\n Bitte das Frühzahler-Datum eingeben";
             document.speichern.Fruehzahler_Datum.focus();
             alert(errmsg);
             return false;
        }
        return true;
}
//-->
</script>
</head>
<body>
<?php
//wenn keine id übergeben wurde, dann die
if (!$_GET['regatta_id']) die;

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

	
//******************************************
//******************************************
	
	
	




	
	
//wurde auf speichern geklickt?
if ($_POST['speichern']=="Speichern") {
	//Datensatz updaten
	//echo "<br>offene_klasse_mit_spi: ".$_POST['offene_klasse_mit_spi'];
	//echo "<br>offene_klasse_ohne_spi: ".$_POST['offene_klasse_ohne_spi'];
	if ($_POST['offene_klasse_mit_spi']==1) {
		$offene_klasse_mit_spi=1;	
	}
	else {
		$offene_klasse_mit_spi=0;
	}
	
	if ($_POST['offene_klasse_ohne_spi']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$offene_klasse_ohne_spi=1;	
	}
	else {
		$offene_klasse_ohne_spi=0;
	}
	if ($_POST['kornati_cup']==1) {
		//echo "offene klasse ohne spi ist angehakt";
		$kornati_cup=1;	
	}
	else {
		$kornati_cup=0;
	}

	
	//alle DB- Updates, Inserts, etc. in eine Transaktion einschließen
	try {
		$mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$mydb->beginTransaction();
		
		//**************************************************************************************************************************************************************************
		//***************************************   Definition von 
		//***************************************   PrepareStatements und gleichbleibende bindParameter   **************************************************************************
		//**************************************************************************************************************************************************************************
		//alle Prepare-Statements bis auf _select stehen hier im if=speichern. _select muss außerhalb stehen.
		//---------------------------------------
		//_update 
		//--> dieses Prepare-Statement muss innerhalb von if=speichern sein,
		//weil sonst die $Post-Variablen nicht bekannt sind
		
		
		$sql_update="UPDATE tbl_regatta ";
		$sql_update.="SET Regatta_Name='".$_POST['Regatta_Name']."',restzahlungen_verschickt='".$_POST['restzahlungen_verschickt']."',regatta_kuerzel='".$_POST['regatta_kuerzel']."',kornati_cup='".$_POST['kornati_cup']."',Regatta_Beginn='".$_POST['Regatta_Beginn']."',Regatta_Ende='".$_POST['Regatta_Ende']."', ";
		$sql_update.="Kosten_Boot='".$_POST['Kosten_Boot']."',Kosten_Person='".$_POST['Kosten_Person']."',Kosten_erm_Boot='".$_POST['Kosten_erm_Boot']."', ";
		$sql_update.="Fruehzahler_Datum='".$_POST['Fruehzahler_Datum']."',restzahlung_faellig_bis='".$_POST['restzahlung_faellig_bis']."', ";
		$sql_update.="Disclaimer='".$_POST['Disclaimer']."',Disclaimer_englisch='".$_POST['Disclaimer_englisch']."', Veranstaltungslogo='".$_POST['Veranstaltungslogo']."',Anzahlungshoehe='".$_POST['Anzahlungshoehe']."',offene_klasse_mit_spi=".$offene_klasse_mit_spi.",offene_klasse_ohne_spi=".$offene_klasse_ohne_spi.",letzte_rg_nr=".$_POST['letzte_rg_nr']." ";	
		$sql_update.="WHERE (regatta_id=:regatta_id)";

		$statement_update = $mydb->prepare($sql_update);
		$statement_update->bindParam(':regatta_id', $_SESSION['sess_regatta_id']);	
		
		
		
		//-------------------------------------
		//_count
		//ich brauche die Anzal an Datensätzen -> Prepare-Statement kann ich für beide Gruppen verwenden.
		//$num_rows muss die Anzahl an Datensätzen zugewiesen bekommen.
		$sql_count = "SELECT  COUNT(*) FROM `tbl_gruppe` WHERE ((regatta_fid=:regatta_id) &(Gruppe=:Gruppe))";

		$statement_count = $mydb->prepare($sql_count);

		//bindParam :regatta_id ist in beiden Fällen gleich und muss nicht zweimal definiert werden.
		$statement_count->bindParam(':regatta_id', $_SESSION['sess_regatta_id']);


		//-------------------------------------
		//_ins
		$sql_ins="INSERT INTO tbl_gruppe (regatta_fid, Gruppe) ";
		$sql_ins.="VALUES (:regatta_id, :Gruppe)";

		$statement_ins = $mydb->prepare($sql_ins);
		$statement_ins->bindParam(':regatta_id', $_SESSION['sess_regatta_id']);		


		//--------------------------------------
		//_del
		$sql_del="DELETE FROM tbl_gruppe WHERE ((regatta_fid=:regatta_id) & (Gruppe=:Gruppe))";

		$statement_del = $mydb->prepare($sql_del);
		$statement_del->bindParam(':regatta_id', $_SESSION['sess_regatta_id']);		
		//**************************************************************************************************************************************************************************		
		//*************************************** ENDE                            **************************************************************************************************
		//*************************************** Definition der PrepareStatements und der gleichbleibenden bindParameters   *******************************************************
		//**************************************************************************************************************************************************************************	

		
	
		
		//Regatta-Daten speichern -> Update auf tbl_Regatta
		if ($statement_update->execute()) {}		//in ein If einbinden, denn execute() gäbe bei Fehler im sql-Statement false zurück und würde die Code-Ausführung mit einer formatierten Ausgabe im Browser unterbrechen
	  

		//**************************************************************************************************************************************************************************
		//*************************************** offene Klasse mit Spi     *******************************************************************************************************
		//**************************************************************************************************************************************************************************
		//--- ab hier brauche ich für offene Klasse ohne Spi dann eine Kopie dieses Code-Fragmentes, wo ich dann nur 'offene Klasse mit Spi' mit 'offene Klasse ohne Spi' ersetze
		//binParam für 'offene Klasse mit Spi' definieren.
		$statement_count->bindValue(':Gruppe', 'offene Klasse mit Spi');
		
		if ($statement_count->execute()) {
			$num_rows = $statement_count->fetchcolumn();	//fetchcolumn() gibt den Inhalt der ersten Spalte in der aktuellen (also momentan ersten) Zeile aus.
 		}
		//------------------------------------------
	
		
		//**************************************************
		if ($offene_klasse_mit_spi==1) {
			//echo "<br>offene klasse mit spi ist angehakt<br>";		//da geht er rein
			//überprüfen,ob offene Klasse mit Spi in tbl gruppe ist. Falls nicht, dann einragen
			if ($num_rows==0) {
				//Gruppe offene Klasse mit Spi in tbl_Gruppe eintragen
				//echo "<br>offene klasse mit spi ist angehakt und die Gruppe ist noch nicht eingetragen<br>";
				$statement_ins->bindValue(':Gruppe', 'offene Klasse mit Spi');
				if ($statement_ins->execute()) {}
			}
		}
		else {
			//echo "<br>offene klasse mit spi ist nicht angehakt<br>";

			//überprüfen,ob offene Klasse mit Spi in tbl gruppe ist. Falls ja, dann löschen
			if ($num_rows>0) {
				//echo "<br>offene klasse mit spi ist nicht angehakt und die Gruppe ist aber eingetragen<br>";
				$statement_del->bindValue(':Gruppe', 'offene Klasse mit Spi');
				if ($statement_del->execute()) {}				
			}
		}
		//**************************************************************************************************************************************************************************
		//*************************************** ENDE                        ******************************************************************************************************
		//*************************************** offene Klasse mit Spi      ******************************************************************************************************
		//**************************************************************************************************************************************************************************

		
		
		
		
		
		
		

		//**************************************************************************************************************************************************************************
		//*************************************** offene Klasse ohne Spi     ******************************************************************************************************
		//**************************************************************************************************************************************************************************
		
		//binParam für 'offene Klasse ohne Spi' definieren.
		$statement_count->bindValue(':Gruppe', 'offene Klasse ohne Spi');
		
		if ($statement_count->execute()) {
			$num_rows = $statement_count->fetchcolumn();	//fetchcolumn() gibt den Inhalt der ersten Spalte in der aktuellen (also momentan ersten) Zeile aus.
 		}
		//------------------------------------------
		
	
		
		//**************************************************
		if ($offene_klasse_ohne_spi==1) {
			//echo "<br>offene klasse ohne spi ist angehakt<br>";		//da geht er rein
			//überprüfen,ob offene Klasse ohne Spi in tbl gruppe ist. Falls nicht, dann einragen
			if ($num_rows==0) {
				//Gruppe offene Klasse ohne Spi in tbl_Gruppe eintragen
				//echo "<br>offene klasse ohne spi ist angehakt und die Gruppe ist noch nicht eingetragen<br>";
				$statement_ins->bindValue(':Gruppe', 'offene Klasse ohne Spi');
				if ($statement_ins->execute()) {}
			}
		}
		else {
			//echo "<br>offene klasse ohne spi ist nicht angehakt<br>";

			//überprüfen,ob offene Klasse ohne Spi in tbl gruppe ist. Falls ja, dann löschen
			if ($num_rows>0) {
				//echo "<br>offene klasse ohne spi ist nicht angehakt und die Gruppe ist aber eingetragen<br>";
				$statement_del->bindValue(':Gruppe', 'offene Klasse ohne Spi');
				if ($statement_del->execute()) {}				
			}
		}		
		//**************************************************************************************************************************************************************************
		//*************************************** ENDE                        ******************************************************************************************************
		//*************************************** offene Klasse ohne Spi     ******************************************************************************************************
		//**************************************************************************************************************************************************************************			

	//****
	//Transation abschließen bzw. Fehler abfangen
	$mydb->commit();
} 
catch (PDOException $e) {
	debug_to_console("Fehler: ".$e->getMessage());
	debug_to_console("Fehler bei Update: ".$statement_update->errorInfo());
  $mydb->rollBack();
}
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php'; ?>	
<div id="content">
<table>
	<tr>
		<td><h1>Regatta-Administration</h1></td>
	</tr>
</table>
	
	
<form method="post" onSubmit="return checkForm()" action="<?php echo $PHP_SELF."?regatta_id=".$_SESSION['sess_regatta_id'];?>" name="speichern">
	
<?php
	  //Regatta mit der übergebenen id selektieren


		//**************************************************************************************************************************************************************************
		//***************************************   Definition von 
		//***************************************   PrepareStatements und gleichbleibende bindParameter   **************************************************************************
		//**************************************************************************************************************************************************************************
		//-------------------------------------
		//_select: dieses Prepare-Statement muss als einziges außerhalb von if=speichern stehen, alle anderen Prepare-Statements finden sich dort.
		$sql_select="SELECT regatta_id,Regatta_Name,restzahlungen_verschickt,regatta_kuerzel,damen_shirts,kornati_cup,Regatta_Beginn,Regatta_Ende, Kosten_Boot, Kosten_Person, ";
		$sql_select.="Kosten_erm_Boot, Fruehzahler_Datum, restzahlung_faellig_bis, ";
		$sql_select.="Disclaimer, Disclaimer_englisch, Veranstaltungslogo, Anzahlungshoehe, offene_klasse_mit_spi, offene_klasse_ohne_spi,letzte_rg_nr FROM tbl_regatta ";
		$sql_select.="WHERE regatta_id=:regatta_id";	

		$statement_select = $mydb->prepare($sql_select);

		//bindParam :regatta_id
		$statement_select->bindParam(':regatta_id', $_SESSION['sess_regatta_id']);
		//**************************************************************************************************************************************************************************		
		//*************************************** ENDE                            **************************************************************************************************
		//*************************************** Definition der PrepareStatements und der gleichbleibenden bindParameters   *******************************************************
		//**************************************************************************************************************************************************************************	


	if ($statement_select->execute()) {


	  //Recordset durchwandern,Daten ins Formular eintragen
	  while ($akt_zeile = $statement_select->fetch()) {
?>	
<div id="formular">	
		
<section class="formular-articles">
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>letzte vergebene Rechnungsnr:</td>
			<td><input type="text" name="letzte_rg_nr" value="<?php echo $akt_zeile['letzte_rg_nr']; ?>"></td>
		  </tr>
		</table>
	</article>	
	
	
	
	<?php
   	if ($akt_zeile['restzahlungen_verschickt']==0) {
	?>											   											   
		<article class="box formular">
		  <table>
			  <tr>
				<td colspan="2"><?php include 'alle_rechnungen_aufruf_popup_oeffnen.php'; ?></td>
			  </tr>
			</table>
		</article>

		<article class="box2 formular">
		  <table>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			</table>
		</article>	

		<article class="box2 formular">
		  <table>
			  <tr>
				<td colspan="2"><strong>Achtung!</strong></td>
			  </tr>
			</table>
		</article>	

		<article class="box2 formular">
		  <table>
			  <tr>
				<td colspan="2">Nach dem Erstellen der Abschluss-Rechnungen müssen Sie <a href='javascript:location.reload()'>aktualisieren</a>, damit die letzte vergebene Rechnungsnummer aktualisiert wird.</td>
			  </tr>
			</table>
		</article>	
	<?php
	}	//Ende if
	else {
	?>	
		<article class="box formular">
		  <table>
			  <tr>
				<td colspan="2">Restzahlungen bereits verschickt</td>
			  </tr>
			</table>
		</article>	
	
	
	<?php	
	}		//Ende else							   
    ?>
	
	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">Regatta-Name:</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<input type="text" name="Regatta_Name" value="<?php echo $akt_zeile['Regatta_Name']; ?>"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Regatta-Kürzel:<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kuerzel_popup_oeffnen.php'; ?></td>
			<td>
				<input type="text" name="regatta_kuerzel"  style="width:85%;" value="<?php echo $akt_zeile['regatta_kuerzel']; ?>">
				<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kuerzel_popup_oeffnen.php'; ?>
			  </td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr><td colspan="2">&nbsp;</td></tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">
			<?php
			if ($akt_zeile["damen_shirts"]==1) {
				//angekreuzt
				echo "<input type='checkbox' name='damen_shirts' value='1' checked disabled> T-Shirt-Größen für Damen verfügbar?";

			 }
			 else {
				//nicht angekreuzt
				echo "<input type='checkbox' name='damen_shirts' value='1' disabled> T-Shirt-Größen für Damen verfügbar?";				 
			 }													   
			?>													   
			</td>
		  </tr>
		</table>
	</article>		
	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">
			<?php
			if ($akt_zeile["kornati_cup"]==1) {
				//angekreuzt
				echo "<input type='checkbox' name='kornati_cup' value='1' checked> Kornati-Cup";

			 }
			 else {
				//nicht angekreuzt
				echo "<input type='checkbox' name='kornati_cup' value='1'> Kornati-Cup";				 
			 }											   
			?>													   
			</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Beginn (yyyy-mm-tt):</td>
			<td>
				<input type="text" name="Regatta_Beginn" value="<?php echo $akt_zeile['Regatta_Beginn']; ?>">
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Ende (yyyy-mm-tt):</td>
			<td>
				<input type="text" name="Regatta_Ende" value="<?php echo $akt_zeile['Regatta_Ende']; ?>">
			  </td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Kosten Veranstaltungspackage / Boot:</td>
			<td>
				<input type="text" name="Kosten_Boot" value="<?php echo $akt_zeile['Kosten_Boot']; ?>">
			  </td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Kosten Veranstaltungspackage / Person:</td>
			<td>
				<input type="text" name="Kosten_Person" value="<?php echo $akt_zeile['Kosten_Person']; ?>">
			  </td>
		  </tr>
		</table>
	</article>		
	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>
				Kosten ermäßigtes Package pro Boot:
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
			<td>
				<input type="text" name="Kosten_erm_Boot" style="width:85%;" value="<?php echo $akt_zeile['Kosten_erm_Boot']; ?>">
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>
				Frühzahlerdatum (yyyy-mm-tt):
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
			<td>
				<input type="text" name="Fruehzahler_Datum" style="width:85%;" value="<?php echo $akt_zeile['Fruehzahler_Datum']; ?>">
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Restzahlung fällig bis (yyyy-mm-tt):</td>
			<td>
				<input type="text" name="restzahlung_faellig_bis" value="<?php echo $akt_zeile['restzahlung_faellig_bis']; ?>">
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Anzahlungshöhe:</td>
			<td>
				<input type="text" name="Anzahlungshoehe" value="<?php echo $akt_zeile['Anzahlungshoehe']; ?>">
			  </td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		</table>
	</article>		

	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">
				<?php 
				//echo "<br> akt_zeile offene_klasse mit spi: ".$akt_zeile["offene_klasse_mit_spi"];
				 if ($akt_zeile["offene_klasse_mit_spi"]==1) {
					//angekreuzt
					echo "<input type='checkbox' name='offene_klasse_mit_spi' value='1' checked> Offene Klasse mit Spi";

				 }
				 else {
					//nicht angekreuzt
					echo "<input type='checkbox' name='offene_klasse_mit_spi' value='1'> Offene Klasse mit Spi";				 
				 }
				?>
			  </td>
		  </tr>
		</table>
	</article>			

	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">
				<?php 
				if ($akt_zeile["offene_klasse_ohne_spi"]==1) {
				//angekreuzt
				echo "<input type='checkbox' name='offene_klasse_ohne_spi' value='1' checked> Offene Klasse ohne Spi";

				 }
				 else {
					//nicht angekreuzt
					echo "<input type='checkbox' name='offene_klasse_ohne_spi' value='1'> Offene Klasse ohne Spi";				 
				 }
				?>
			  </td>
		  </tr>
		</table>
	</article>			
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">Disclaimer deutsch:</td>
		  </tr>
		</table>
	</article>		
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<textarea name="Disclaimer" style="width: 100%;"><?php echo $akt_zeile["Disclaimer"]; ?></textarea>
			  </td>
		  </tr>
		</table>
	</article>	
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">Disclaimer englisch:</td>
		  </tr>
		</table>
	</article>		
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<textarea name="Disclaimer_englisch" style="width: 100%;"><?php echo $akt_zeile["Disclaimer_englisch"]; ?></textarea>
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">Pfad zum Veranstaltungslogo:</td>
		  </tr>
		</table>
	</article>		
	
	<article class="box2 formular">
	  <table>
		  <tr>
			<td colspan="2">
				<input type="text" name="Veranstaltungslogo" value="<?php echo $akt_zeile['Veranstaltungslogo']; ?>">
			  </td>
		  </tr>
		</table>
	</article>		
</section>

</div> <!-- div id=formular-->
</div>   <!--  div id=content -->
	
<?php	  
		 }
}
?>	
	
	
<!-------------------------------------------------------------------------->
<!-- Beginn Navigationsbuttons --------------------------------------------->
<section class="navi-articles">
	<article class="box navi">
		<table align="center">	
			<tr>
				<td>
					<input type="submit" name="speichern" value="Speichern">
				</td>
			</tr>
		</table>
			</form>
	</article>	
	
	<article class="box navi">
		<table align="center">	
			<tr>
				<td>
					<form class="navi_hoehe" method="post" action="/regattaliste.php" name="regattaliste">
					<input type="submit" name="regattaliste" value="Regattaliste">
					</form>
				</td>
			</tr>
		</table>
	</article>	
	
	<article class="box navi">
		<table align="center">	
			<tr>
				<td>
					<form class="navi_hoehe" method="post" action="/restzahlungsliste.php?regatta_id=<?php echo $regatta_id;?> " name="restzahlungsliste">
					<input type="submit" name="restzahlungsliste" value="Restzahlungs-Liste">
					</form>
				</td>
			</tr>
		</table>
	</article>		
</section>
</body>
</html>