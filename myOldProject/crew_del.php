<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in crew_del.php");




session_start();

//hier wird das übergebene Crewmitglied gelöscht
//wenn keine id übergeben wurde, dann die
if (!$_GET['crewmitglied_id']) die;

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

if ($_GET['loeschen']='Loeschen')
{	
		
	//das übergebene Crewmitglied löschen
	$sql="DELETE FROM tbl_crewmitglied WHERE crewmitglied_id=".$_GET['crewmitglied_id'];
	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}
}
$header="location:http://".$_SERVER['SERVER_NAME']."/crewliste.php?teilnehmer_id=".$_SESSION['sess_login_teilnehmer_id'];
Header($header);

debug_to_console("Ende crew_del.php");
?>
