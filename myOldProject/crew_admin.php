<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crew_admin.php");




header("Content-Type: text/html; charset=utf-8");

session_start();		//damit ich auf sess_regatta_id teilnehmer_id zugreifen kann ...
//$crewmitglied_id wird übergeben

//wenn keine id (sprich crewmitglied_id)übergeben wurde, dann "stirb"
if (!$_GET['crewmitglied_id']) die;

$_SESSION['sess_crewmitglied_id']=$_GET['crewmitglied_id'];

$sprache = $_SESSION['sprache'];
if ($sprache == "deutsch") {
	//Variablen;
	$title = "Veraltung eines Crew-Mitglieds";
	
	$a_nachname = "Nachname";
	$a_vorname = "Vorname";
	$a_strasse ="Strasse";
	$a_plz ="PLZ";
	$a_ort = "Ort";
	$a_land = "Land";
	$a_geburts_datum ="Geburtsdatum (yyyy-mm-tt)";
	$a_geburtsort = "Geburtsort";
	$a_staatsbuergerschaft = "Staatsb&uuml;rgerschaft";
	$a_pass_nummer = "Pass-Nummer";
	$a_email = "Email";
	$a_shirt_groesse = "Shirt-Gr&ouml;ße";
	$a_club = "Club";
	$a_oesv_nr = "&Ouml;SV-Nr.";
	$a_mobil_nummer_zu_hause = "Mobil-Nummer zu Hause";
	$a_mobil_nummer_vor_ort = "Mobil-Nummer vor Ort";	
	$button_speichern = "Speichern";
	$button_crewliste = "Crewliste";
	$button_loeschen ="L&ouml;schen";
}
else {
	//Variablen
	$title = "Administrate a member of the crew";

	$a_nachname = "Last name";
	$a_vorname = "First name";
	$a_strasse ="Street";
	$a_plz ="ZIP";
	$a_ort = "City";
	$a_land = "Country";
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
	$button_speichern = "Save";
	$button_crewliste = "List of crew members";
	$button_loeschen ="Delete";
}

?>
<html>
<head>
<title>Crewmitglied verwalten</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>
<script src="/functions.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function checkForm()
{
        var errmsg="";

			var err_unterschreiben;
			var err_nachname;
			var err_vorname;
			var err_strasse;
			var err_plz;
			var err_ort;
			var err_land;
			var err_email;
			var err_email_gueltig;

			//je nach Sprache die verschiedenen Fehlermeldungen auf deutsch oder englisch setzen
			if (document.crew_eingabe.sprache.value == "deutsch") {
				err_unterschreiben = "\n Bitte erklären Sie sich mit den Haftungs- und Datenschutzbestimmungen einverstanden!";
				err_nachname = "\n Bitte Nachname eingeben!";
				err_vorname = "\n Bitte Vornamen eingeben!";
				err_strasse = "\n Bitte Strasse eingeben!";
				err_plz = "\n Bitte PLZ eingeben!";
				err_ort = "\n Bitte Ort eingeben!";
				err_land ="\n Bitte Land eingeben!";
				err_email_gueltig ="\n Bitte gültige Email-Adresse eingeben!";
			}
			else {
				err_unterschreiben = "\n Pleace agree to the regulations concerning data protection and liability!";
				err_nachname = "\n Please enter last name!";
				err_vorname = "\n Please enter first name!";
				err_strasse ="\n Please enter street!";
				err_plz = "\n Please enter ZIP Code!";
				err_ort = "\n Please enter city!";
				err_land ="\n Please enter country!";
				err_email_gueltig ="\n Please enter a valid email address!";
			}

		if (document.crew_eingabe.unterschrieben.checked == 0)
		{
			 errmsg=err_unterschreiben;
			 document.crew_eingabe.unterschrieben.focus();
			 alert(errmsg);
			 return false;
		}
		
		if (document.crew_eingabe.nachname.value == "")
        {
             errmsg=err_nachname;
             document.crew_eingabe.nachname.focus();
             alert(errmsg);
             return false;
        }
		
        if (document.crew_eingabe.vorname.value == "")
        {
                errmsg += err_vorname;
                document.crew_eingabe.vorname.focus();
                alert(errmsg);
                return false;
        }

        if (document.crew_eingabe.strasse.value == "")
        {
             errmsg=err_strasse;
             document.crew_eingabe.strasse.focus();
             alert(errmsg);
             return false;
        }

        if (document.crew_eingabe.plz.value == "")
        {
             errmsg=err_plz;
             document.crew_eingabe.plz.focus();
             alert(errmsg);
             return false;
        }

        if (document.crew_eingabe.ort.value == "")
        {
             errmsg=err_ort;
             document.crew_eingabe.ort.focus();
             alert(errmsg);
             return false;
        }

        if (document.crew_eingabe.land.value == "")
        {
             errmsg=err_land;
             document.crew_eingabe.land.focus();
             alert(errmsg);
             return false;
        }

        if (document.crew_eingabe.email.value!="")
        {
            var emd=document.crew_eingabe.email.value;

            if ((emd.indexOf("@")==-1) || (emd.indexOf(".") ==-1) || (emd.indexOf("@") > emd.lastIndexOf(".")) || (emd.lastIndexOf(".") > (emd.length-3)))
            {
                 errmsg=err_email_gueltig;
                 alert(errmsg);
                 return false;
            }
        }

        return true;
}
//-->
</script>

		
<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
</head>
<body>
<?php
//bis hierher kommt er : echo "blabla";  
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//echo "<br> \$_SESSION['sess_regatta_id']: ".$_SESSION['sess_regatta_id'];
//Regattakopf includieren
$regatta_id=$_SESSION['sess_regatta_id'];
include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php';
?>

<div id="content">

<?php
//Seitenkopf includieren
$teilnehmer_id=$_SESSION['sess_login_teilnehmer_id']; //wird vor dem include von seitenkopf_schreiben_crew.php benötigt

//echo $_SESSION['sess_login_teilnehmer_id'];
include $_SERVER['DOCUMENT_ROOT'].'/seitenkopf_schreiben_crew.php';

// da kommt er nicht mehr her echo "blabla";
//******************************************
//******************************************
//wurde auf speichern geklickt?

//if ($_POST['speichern']=="Speichern")
if (isset($_POST['speichern']))
    {
    //Datensatz updaten

    //sql-Statement erstellen
    $sql="UPDATE tbl_crewmitglied ";
    $sql.="SET Nachname='".$_POST['nachname']."',Vorname='".$_POST['vorname']."', ";
	$sql.="Strasse='".$_POST['strasse']."',PLZ='".$_POST['plz']."',Ort='".$_POST['ort']."', ";
	$sql.="Land='".$_POST['land']."',Email='".$_POST['email']."',Club='".$_POST['club']."', ";
	$sql.="Shirt='".$_POST['shirt']."',mobil_nummer_zu_hause='".$_POST['mobil_nummer_zu_hause']."', ";
	$sql.="mobil_nummer_vor_ort='".$_POST['mobil_nummer_vor_ort']."',oesv_nr='".$_POST['oesv_nr']."', ";
	$sql.="geb_datum='".$_POST['geb_datum']."',geb_ort='".$_POST['geb_ort']."', ";
	$sql.="staatsbuergerschaft_Nr='".$_POST['staatsbuergerschaft_Nr']."',passnr='".$_POST['passnr']."', ";
	$sql.="unterschrieben='".$_POST['unterschrieben']."' ";
    $sql.="WHERE crewmitglied_id=".$_SESSION['sess_crewmitglied_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
    }
?>

 
  <form method="post" onSubmit="return checkForm()" action="<?php echo $PHP_SELF."?crewmitglied_id=".$_SESSION['sess_crewmitglied_id'];?>" name="crew_eingabe">
	   <table>
          <tr><td align="left"><h1>Crewmitglied verwalten</h1></td></tr>
            <tr>
                <td><input type="hidden" name="sprache" width="100" value="<?php echo $sprache; ?>"></td>
            </tr>        
	  </table>
	  
	  
	  
<?php
//Crewmitglied mit der übergebenen id selektieren

//sql-Statement erstellen
$sql="SELECT crewmitglied_id,Nachname,Vorname,Strasse,PLZ,Ort,Land,Email,Club,Shirt, ";
$sql.="mobil_nummer_zu_hause,mobil_nummer_vor_ort,oesv_nr,geb_datum,geb_ort,staatsbuergerschaft_Nr,passnr, "; 
$sql.="unterschrieben ";
$sql.="FROM tbl_crewmitglied ";
$sql.="WHERE crewmitglied_id=".$_SESSION['sess_crewmitglied_id'];

$statement = $mydb -> prepare($sql);
if ($statement->execute()) {}


//Recordset durchwandern,Daten ins Formular eintragen
while ($akt_zeile=$statement->fetch())
	 {	  
?>	  
	
	  
	  
	  
	  
<div id="formular">	
	
<section class="formular-articles">	 
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_nachname;?>:</td>
			<td><input type='text' name='nachname' value='<?php echo $akt_zeile["Nachname"];?>'</td>
		</tr>
	</table>
</article>
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_vorname;?>:</td>
			<td><input type='text' name='vorname' value='<?php echo $akt_zeile["Vorname"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_strasse;?>:</td>
			<td><input type='text' name='strasse' value='<?php echo $akt_zeile["Strasse"];?>'</td>
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
			<td><?php echo $a_plz;?>:</td>
			<td><input type='text' name='plz' value='<?php echo $akt_zeile["PLZ"];?>'</td>
		</tr>
	</table>
</article>		
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_ort;?>:</td>
			<td><input type='text' name='ort' value='<?php echo $akt_zeile["Ort"];?>'</td>
		</tr>
	</table>
</article>	
	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_land;?>:</td>
			<td><input type='text' name='land' value='<?php echo $akt_zeile["Land"];?>'</td>
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
			<td><?php echo $a_geburts_datum;?>:</td>
			<td><input type='text' name='geb_datum' value='<?php echo $akt_zeile["geb_datum"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_geburtsort;?>:</td>
			<td><input type='text' name='geb_ort' value='<?php echo $akt_zeile["geb_ort"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_staatsbuergerschaft;?>:</td>
			<td>
				<select name="staatsbuergerschaft_Nr"  class="select100">
				<?php
				//options füllen
				//connection.php includieren
				include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

				if ($sprache == "deutsch")
				{	
					$sql2="SELECT Nation_Nr,Nation_Name_deutsch FROM tbl_nationen ";
					$sql2.="ORDER BY Nation_Name_deutsch";

					$statement2 = $mydb -> prepare($sql2);
					if ($statement2->execute()) {}

					//Recordset durchwandern, und die Gruppen in die Liste speichern
					while ($akt_zeile2=$statement2->fetch()) {

					   echo "<option value='".$akt_zeile2["Nation_Nr"]."' ";
					   if ($akt_zeile2["Nation_Nr"]==$akt_zeile["staatsbuergerschaft_Nr"])
					   {						   
							echo " selected";
					   }

						echo ">".$akt_zeile2["Nation_Name_deutsch"];
						echo "</option>";				   
					}
				}
				else
				{
					$sql2="SELECT Nation_Nr,Nation_Name_englisch FROM tbl_nationen ";
					$sql2.="ORDER BY Nation_Name_englisch";

					$statement2 = $mydb -> prepare($sql2);
					if ($statement2->execute()) {}

					//Recordset durchwandern, und die Gruppen in die Liste speichern
					while ($akt_zeile2=$statement2->fetch()) {

					   echo "<option value='".$akt_zeile2["Nation_Nr"]."' ";
					   if ($akt_zeile2["Nation_Nr"]==$akt_zeile["staatsbuergerschaft_Nr"])
					   {						   
							echo " selected";
					   }

						echo ">".$akt_zeile2["Nation_Name_englisch"];
						echo "</option>";				   
					}					
				}

				echo "<option value='0' ";
					if ($akt_zeile["staatsbuergerschaft_Nr"]==0) {
						echo "selected";
					}
				echo "></option>";

				echo "</select>";
				?>
			</td>
		</tr>
	</table>
</article>	
	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_pass_nummer;?>:</td>
			<td><input type='text' name='passnr' value='<?php echo $akt_zeile["passnr"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_email;?>:</td>
			<td><input type='text' name='email' value='<?php echo $akt_zeile["Email"];?>'</td>
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
			<td><?php echo $a_mobil_nummer_zu_hause;?>:</td>
			<td><input type='text' name='mobil_nummer_zu_hause' value='<?php echo $akt_zeile["mobil_nummer_zu_hause"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_mobil_nummer_vor_ort;?>:</td>
			<td><input type='text' name='mobil_nummer_vor_ort' value='<?php echo $akt_zeile["mobil_nummer_vor_ort"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_club;?>:</td>
			<td><input type='text' name='club' value='<?php echo $akt_zeile["Club"];?>'</td>
		</tr>
	</table>
</article>	
	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_oesv_nr;?>:</td>
			<td><input type='text' name='oesv_nr' value='<?php echo $akt_zeile["oesv_nr"];?>'</td>
		</tr>
	</table>
</article>	
	
<article class="box formular">
	<table>
		<tr>
			<td><?php echo $a_shirt_groesse;?>:</td>
			<td>
				<?php 
	  			echo "<select name='shirt'>";
				$shirt_h=$akt_zeile["Shirt"];
				include $_SERVER['DOCUMENT_ROOT'].'/feld_shirt_aufbauen.php';
				?>
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
	  		if ($akt_zeile["unterschrieben"]==1) {
				//echo "offene klasse ohne spi ist angehakt";
				$unterschrieben=1;	
			}
			else {
				$unterschrieben=0;
			}


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

	

<?php
}	//ENDE while
?>
</div>   <!--  div id=content -->	      
          

  
<!-------------------------------------------------------------------------->
<!-- Beginn Navigationsbuttons --------------------------------------------->
<section class="navi-articles">	
	<article class="box navi">
		<table align="center">
			<tr>
				<td>	  
					<input type="submit" name="speichern" value="<?php echo $button_speichern; ?>"></form>
				</td>
			</tr>
		</table>
	</article>	
	
	<article class="box navi">
		<table align="center">
			<tr>
			<form method="post" action="/crew_del.php?loeschen=Loeschen&crewmitglied_id=<?php echo $_SESSION['sess_crewmitglied_id'];?>" name="loeschen">
			<td>    
				<input type="submit" name="loeschen" value="<?php echo $button_loeschen; ?>">       
			</td> 
			</form>       
			</tr>
		</table>
	</article>	
	
	<article class="box navi">
		<table align="center">
			<tr>
			<form method="post" action="/crewliste.php?teilnehmer_id=<?php echo $_SESSION['sess_login_teilnehmer_id'];?>" name="crewliste">
			<td>    
				<input type="submit" name="crewliste" value="<?php echo $button_crewliste; ?>">
			</td> 
			</form>       
			</tr>
		</table>
	</article>		
</section>


</body>
</html>