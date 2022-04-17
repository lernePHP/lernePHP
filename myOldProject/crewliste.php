<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crewliste.php");




header("Content-Type: text/html; charset=utf-8");

//$teilnehmer_id wird übergeben
//Session-Variable für teilnehmer_id definieren, falls das nocht nicht passiert ist ... z.B. beim Teilnehmer-Login

//wenn keine id (sprich teilnehmer)übergeben wurde, dann "stirb"
session_start();

if (!$_GET['teilnehmer_id']) die;

$sprache = $_SESSION['sprache'];
if ($sprache == "deutsch") {
	//Variablen;
	$title = "Verwalten von Crewmitgliedern";
	$crewliste = "Crewliste";
	$verwalten = "verwalten";
	$loeschen = "l&ouml;schen";
	$crewmitglied_hinzufuegen = "Crewmitglied hinzuf&uuml;gen";
	$teilnehmerliste ="Zur&uuml;ck zur Meldeliste";
	$boot_und_skipper_verwalten = "Boot und Skipper verwalten";
}
else {
	//Variablen
	$title = "Administrate Members of the Crew";
	$crewliste = "List of crew members";
	$verwalten = "administrate";
	$loeschen = "delete";
	$crewmitglied_hinzufuegen = "Add a member of crew";
	$teilnehmerliste ="Back to the Entry List";
	$boot_und_skipper_verwalten = "Administrate boat and skipper";
}


$_SESSION['sess_login_teilnehmer_id']=$_GET['teilnehmer_id'];
$teilnehmer_id = $_GET['teilnehmer_id'];

//echo "<br> teilnehmer_id: ".$_SESSION['sess_login_teilnehmer_id'];

if ($_SESSION['sess_login_rechte']=="teilnehmer")
{
	//echo "<br> rechte ist teilnehmer";	
	if ($_SESSION['sess_login_teilnehmer_id'] != $_GET['teilnehmer_id'])
	{
		//echo "<br> sess_login_teilnehmer_id entspricht nicht teilnehmer_id";
		//nicht berechtigte teilnehmernummer wurde übergeben
		Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
	}
}
else
{
	//überprüfen, ob es evtl. der Administrator ist
	if ($_SESSION['sess_login_rechte']!="administrator")
		{
		//keine Berechtigung
		Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
		}
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<title><?php echo $title;?></title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; 		
//Zeichencodierung definieren ?>
	
<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">

</head>
<body>
<?php
$teilnehmer_id=$_GET['teilnehmer_id'];
//teilnehmer_suchen.php includieren. in dieser Datei wird definiert:
//regatta_id und andere Teilnehmer-Dateien (Uns gehts hier um regatta_id)
//wichtig: zuvor muss teilnehmer_id feststehen; das ist hier der Fall: wird  übergeben.
include $_SERVER['DOCUMENT_ROOT'].'/teilnehmer_suchen.php';

$regatta_id=$_SESSION['sess_regatta_id'];
include $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php';
?>

<div id="content">
	
	
<?php

include $_SERVER['DOCUMENT_ROOT'].'/seitenkopf_schreiben_crew.php';

?>
<table cellpadding="7" cellspacing="0">
<?php
//laufende Durchnumerierung der Crewmitglieder
$nr=2;		//die Durchnummerierung der Crewmitglieder beginnt mit 2, da Nr. 1 der Skipper ist.

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';


//sql-Statement erstellen
//teilnehmer_id wird übergeben
$sql="SELECT crewmitglied_id,teilnehmer_fid,nachname,vorname FROM tbl_crewmitglied ";
$sql.="WHERE (teilnehmer_fid=".$_GET['teilnehmer_id'].") ORDER BY nachname,vorname";

$statement = $mydb->prepare($sql);
if($statement->execute()){}

if ($statement->rowCount()==0)
{
	//noch keine Crewmitglieder gespeichert
	echo "<tr><td>Es sind noch keine Crewmitglieder eingetragen!</td></tr>";
}		
else
{	
	
	//Überschrift "Skipper"
	echo "<tr>";
	echo "<td colspan='4'>";
	echo "<h3>Skipper</h3>";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	
		echo "<td>";
		echo "1";
		echo "</td>";
		
		echo "<td>";
		echo $skipper_name;
		echo "</td>";
		
		//das teste ich gerade
		switch ($_SESSION['sess_login_rechte'])
		{
			case "administrator":
				echo "<td><a href='/teilnehmer_admin_administrator.php?teilnehmer_id=".$_GET['teilnehmer_id']."&erst_aufruf=1'>".$verwalten."</a></td>";			
				break;
			case "teilnehmer":
				//getestet und funktioniert, aber der eigenartige switch-text steht trotzdem da ...
				echo "<td><a href='/teilnehmer_admin_teilnehmer.php?teilnehmer_id=".$_GET['teilnehmer_id']."&erst_aufruf=1'>".$verwalten."</a></td>";
				break;			
			default:
				break;			
		}		
		echo "<td>&nbsp;</td>";                    

	echo "</tr>";
	
	
	//es sind schon Crewmitglieder eingetragen, Crewliste aufbauen
	//Überschrift "Crewliste"
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr>";
	echo "<td colspan='4'>";
	echo "<h3>".$crewliste."</h3>";
	echo "</td>";
	echo "</tr>";
	while ($akt_zeile=$statement->fetch())
		   {
		   //laufende Nummer, Crew-Name und die zwei Links / Buttons in die Tabelle eintragen
		   echo "<tr>";
				echo "<td>".$nr."</td>";
				echo "<td align='left'>".$akt_zeile["nachname"]." ".$akt_zeile["vorname"]."</td>";
				echo "<td><a href='/crew_admin.php?crewmitglied_id=".$akt_zeile["crewmitglied_id"]."'>".$verwalten."</a></td>";			  						
				echo "<td><a href='/crew_del.php?loeschen=Loeschen&crewmitglied_id=".$akt_zeile["crewmitglied_id"]."'>".$loeschen."</a></td>";							
		   echo "</tr>";
		   //lfd. Nr erhöhen
		   $nr++;
		   }
}	
?>

</table>
</div>
<section class="navi-articles">

	<!---------------------------------------------------------->
	<article class="box navi">
      <table align="center"><tr><td>
		  <a href="/crew_eingabe.php"><?php echo $crewmitglied_hinzufuegen; ?></a>
		  </td></tr></table>
    </article>
	
	

	
	
	<!---------------------------------------------------------->	
   <?php
   //hier muss ich entweder zu teilnehmerliste.php... oder teilnehmerliste_lesen.php verzweigen, je nachdem,
   //ob $sess_login_rechte = administrator oder teilnehmer

   //hier hat sess_regatta_id den richtigen Wert!
   switch ($_SESSION['sess_login_rechte'])
   {
		case "administrator":
			$href_var = "/teilnehmerliste.php?regatta_id=".$_SESSION['sess_regatta_id'];
			break;
		case "teilnehmer":
			$href_var ="/teilnehmerliste_lesen.php?regatta_id=".$_SESSION['sess_regatta_id'];
			break;
		default:
			$href_var="/teilnehmerliste_lesen.php?regatta_id=".$_SESSION['sess_regatta_id'];
			break;
	}

	?>

    <article class="box navi">
  		<table align="center">
			<tr>
				<td>
    	  			<a href="<?php echo $href_var?>"><?php echo $teilnehmerliste; ?></a>   
				</td>
			</tr>
		</table>
	</article>
	
	
	
	

	
	<!---------------------------------------------------------->	
	<?php
 	   switch ($_SESSION['sess_login_rechte'])
	   {
	   		case "administrator":
			   $href_var = "/teilnehmer_admin_administrator.php?teilnehmer_id=".$_GET['teilnehmer_id']."&erst_aufruf=1";
				break;
			case "teilnehmer":
			   $href_var ="/teilnehmer_admin_teilnehmer.php?teilnehmer_id=".$_GET['teilnehmer_id']."&erst_aufruf=1";
				break;
			default:
				break;
		}
	?>

    <article class="box navi">
          <table align="center"><tr><td>
    	  <a href="<?php echo $href_var?>"><?php echo $boot_und_skipper_verwalten; ?></a>   
          </td></tr></table>
	</article>
						
</section>
</body>
</html>