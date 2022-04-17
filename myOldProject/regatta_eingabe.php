<?php
header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<title>Eingabe einer Regatta</title>
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
		
        if (document.regatta_eingabe.Regatta_Name.value == "")
        {
                errmsg += "\n Bitte Regatta-Name eingeben";
                document.regatta_eingabe.Regatta_Name.focus();
                alert(errmsg);
                return false;
        }

        if (document.regatta_eingabe.regatta_kuerzel.value == "")
        {
                errmsg += "\n Bitte Regatta-Kürzel eingeben";
                document.regatta_eingabe.regatta_kuerzel.focus();
                alert(errmsg);
                return false;
        }
		
        if (document.regatta_eingabe.Regatta_Beginn.value == "")
        {
             errmsg="\n Bitte Regatta_Beginn eingeben";
             document.regatta_eingabe.Regatta_Beginn.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.regatta_eingabe.Regatta_Beginn.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für den Regatta_Beginn eintragen";
                        document.regatta_eingabe.Regatta_Beginn.focus();
                        alert(errmsg);
                        return false;
                        }

                if (document.regatta_eingabe.Regatta_Ende.value == "")
        {
             errmsg="\n Bitte Regatta_Ende eingeben";
             document.regatta_eingabe.Regatta_Ende.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.regatta_eingabe.Regatta_Ende.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für das Regatta_Ende eintragen";
                        document.regatta_eingabe.Regatta_Ende.focus();
                        alert(errmsg);
                        return false;
                        }

                //überprüfen, ob das Ende-Datum nach dem Anfangsdatum liegt
                if (document.regatta_eingabe.Regatta_Beginn.value>document.regatta_eingabe.Regatta_Ende.value)
                        {
                        errmsg="\n Regatta-Beginn liegt nach dem Regatta-Ende";
                        document.regatta_eingabe.Regatta_Ende.focus();
                        alert(errmsg);
                        return false;
                        }
		if (document.regatta_eingabe.Kosten_Boot.value == "")
        {
                errmsg += "\n Bitte die Kosten für das Veranstaltungspackage pro Boot eingeben";
                document.regatta_eingabe.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Kosten_Boot.value <0)
        {
                errmsg += "\n Die Kosten für das Veranstaltungspackage pro Boot können nicht negativ sein!";
                document.regatta_eingabe.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Kosten_Person.value == "")
        {
                errmsg += "\n Bitte die Kosten für das Veranstaltungspackage pro Person eingeben";
                document.regatta_eingabe.Kosten_Person.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Kosten_Person.value <0)
        {
                errmsg += "\n Die Kosten für das Veranstaltungspackage pro Person können nicht negativ sein!";
                document.regatta_eingabe.Kosten_Person.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Kosten_erm_Boot.value == "")
        {
                errmsg += "\n Bitte die Kosten für das ermäßigte Package pro Boot eingeben";
                document.regatta_eingabe.Kosten_erm_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Kosten_erm_Boot.value <0)
        {
                errmsg += "\n Die Kosten für das ermäßigte Package pro Boot können nicht negativ sein!";
                document.regatta_eingabe.Kosten_Boot.focus();
                alert(errmsg);
                return false;
        }
		
		if (document.regatta_eingabe.Fruehzahler_Datum.value == "")
        {
             errmsg="\n Bitte das Frühzahler-Datum eingeben";
             document.regatta_eingabe.Fruehzahler_Datum.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.regatta_eingabe.Fruehzahler_Datum.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Datum für das Frühzahler-Datum eintragen";
                        document.regatta_eingabe.Fruehzahler_Datum.focus();
                        alert(errmsg);
                        return false;
                        }

		if (document.regatta_eingabe.restzahlung_faellig_bis.value == "")
        {
             errmsg="\n Bitte ein Fälligkeitsdatum für die Restzahlung eingeben";
             document.regatta_eingabe.restzahlung_faellig_bis.focus();
             alert(errmsg);
             return false;
        }

                //überprüfen, ob das eingegebene Datum ein Datum ist
                if (isDatum(document.regatta_eingabe.restzahlung_faellig_bis.value)==false)
                        {
                        errmsg="\n Bitte ein gültiges Fälligkeitsdatum für die Restzahlung eingeben";
                        document.regatta_eingabe.restzahlung_faellig_bis.focus();
                        alert(errmsg);
                        return false;
                        }
	
		if (document.regatta_eingabe.Anzahlungshoehe.value == "")
        {
             errmsg="\n Bitte die Höhe der Anzahlung eingeben";
             document.regatta_eingabe.Anzahlungshoehe.focus();
             alert(errmsg);
             return false;
        }
		
		if (document.regatta_eingabe.Anzahlungshoehe.value <0)
        {
             errmsg="\n Bitte das Frühzahler-Datum eingeben";
             document.regatta_eingabe.Fruehzahler_Datum.focus();
             alert(errmsg);
             return false;
        }
		        
        return true;
}
//-->
</script>
</head>
<body>
<div id="content">

<img src="bilder/datenbank-kopf.png" width="100%" height="auto" alt=""/> 
	
<form method="post" onSubmit="return checkForm()" action="/regatta_speichern.php" name="regatta_eingabe">	
<table cellpadding="5" cellspacing="0">
        <tr><td><h1>Eingabe einer Regatta</h1></td></tr>
</table>
	
<div id="formular">		
<section class="formular-articles">
	
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
			<td colspan="2"><input type="text" name="Regatta_Name" style="width: 100%;"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Regatta-Kürzel:<?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kuerzel_popup_oeffnen.php';?></td>
			<td><input type="text" name="regatta_kuerzel" style="width:85%;"><?php include $_SERVER['DOCUMENT_ROOT'].'/regatta_kuerzel_popup_oeffnen.php';?></td>
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
				<input type='checkbox' name='damen_shirts' value='1'> T-Shirt-Größen für Damen verfügbar? (Achtung! Kann später nicht mehr geändert werden!)
            </td> 
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">              
				<input type='checkbox' name='kornati_cup' value='1'> Kornati-Cup 
				<?php
                include $_SERVER['DOCUMENT_ROOT'].'/kornati_cup_popup_oeffnen.php';
                ?>    
            </td> 
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Beginn (yyyy-mm-tt):</td>
			<td><input type="text" name="Regatta_Beginn"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Ende (yyyy-mm-tt):</td>
			<td><input type="text" name="Regatta_Ende"></td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Kosten P/Boot:</td>
			<td><input type="text" name="Kosten_Boot"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Kosten P/Person:</td>
			<td><input type="text" name="Kosten_Person"></td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>
				Kosten ermäßigtes P/Boot:
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
			<td>
				<input type="text" name="Kosten_erm_Boot" style="width:85%;">
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
				<input type="text" name="Fruehzahler_Datum" style="width:85%;">
				<?php include $_SERVER['DOCUMENT_ROOT'].'/fruehzahler_popup_oeffnen.php'; ?>
			  </td>
		  </tr>
		</table>
	</article>		
	
	<article class="box formular">
	  <table>
		  <tr>
			<td>Restzahlung fällig bis (yyyy-mm-tt):</td>
			<td><input type="text" name="restzahlung_faellig_bis"></td>
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
			<td><input type="text" name="Anzahlungshoehe"></td>
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
				<input type="checkbox" name="offene_klasse_mit_spi" value="1" checked> Offene Klasse mit Spi
			</td>
		  </tr>
		</table>
	</article>	
	
	<article class="box formular">
	  <table>
		  <tr>
			<td colspan="2">
				<input type="checkbox" name="offene_klasse_ohne_spi" value="1" checked> Offene Klasse ohne Spi
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
			<td colspan="2"><textarea name="Disclaimer" style="width: 100%;"></textarea></td>
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
			<td colspan="2"><textarea name="Disclaimer_englisch" style="width: 100%;"></textarea></td>
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
			<td colspan="2"><input name="Veranstaltungslogo" type="text"></td>
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

</section>	
</body>
</html>