<?php
//$teilnehmer_id wird �bergeben
//echo aha;
session_start();

//hier wird der �bergebene Teilnehmer mitsamt seiner Crew (zugeh�riger Detailtabelle) gel�scht.

//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//vor dem L�schen des Teilnehmers muss noch unbedingt die regatta_id ermittelt werden. Die brauche ich,
//um nach dem L�schen zur Teilnehmerliste zu wechseln.

$teilnehmer_id=$_GET['teilnehmer_id'];  //wird vor dem include von teilnehmer_suchen.php ben�tigt

//ermitteln der regatta_id erfolgt durch includieren von:
include $_SERVER['DOCUMENT_ROOT'].'/teilnehmer_suchen.php';
	
//Alle zugeh�rigen Crewmitglieder  l�schen
$sql="DELETE FROM tbl_crewmitglied WHERE teilnehmer_fid=".$_GET['teilnehmer_id'];
//echo $sql;
//sql_Statement absetzen
$statement = $mydb->prepare($sql);
if ($statement->execute()) {}
			

//Teilnehmerboot mit der �bergebenen teilnehmer_id l�schen
$sql="DELETE FROM tbl_teilnehmer_boot WHERE teilnehmer_id=".$_GET['teilnehmer_id'];	
			
$statement = $mydb->prepare($sql);
if ($statement->execute()) {}


//****************************************************
//ein Boot in der betreffenden Gruppe wieder freigeben
$regatta_id=$_SESSION['sess_regatta_id'];
$aktion="verringern";
//$gruppe muss erst mittels gruppe_suchen ermittelt werden
//$regatta_id ist schon definiert
$gruppen_id=$gruppen_fid;	//kommt aus teilnehmer_suchen
include $_SERVER['DOCUMENT_ROOT'].'/gruppe_suchen.php';
$gruppe=$gruppen_name;	//kommt aus gruppe_suchen

include $_SERVER['DOCUMENT_ROOT'].'/vergebene_boote_aendern.php';
//ENDE - ein Boot in der betreffenden Gruppe wieder freigeben
//****************************************************

//echo $_SESSION['sess_regatta_id'];
$header_text= "location:http://".$_SERVER['SERVER_NAME']."/teilnehmerliste.php?regatta_id=".$_SESSION['sess_regatta_id'];
header($header_text);

?>