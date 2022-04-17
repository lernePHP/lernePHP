<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//debug_to_console("Hallo in letzte_rg_nr_inc.php");

//Allgemein:	erhöht die letzte_rg_nr um 1.
//				wird direkt nach dem erstellen einer Rechnung aufgerufen
//Eingang:		$regatta_id	

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//sql-Statement erstellen
$sql="UPDATE tbl_regatta ";
$sql.="SET letzte_rg_nr=letzte_rg_nr+1" ;	
$sql.=" WHERE regatta_id=".$regatta_id;

$statement = $mydb->prepare($sql);

if ($statement->execute()) {}

//debug_to_console("Ende letzte_rg_nr_inc.php");
?>