<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in regatta_del_question.php");

header("Content-Type: text/html; charset=utf-8");

//hierher darf nur der Administrator!
session_start();
if ($_SESSION['sess_login_rechte']!="administrator")
{
	Header("location:http://".$_SERVER['SERVER_NAME']."/index.php");
}

//Session-Variable für regatta_id definieren

//wenn keine id (sprich Regatta-ID)übergeben wurde, dann "stirb"
if (!$_GET['teilnehmer_id']) die;
$teilnehmer_id=$_GET['teilnehmer_id'];

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">		
<title>Regatta löschen?</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>

<link href="/CSS/normalize.css" rel="stylesheet">
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 800px)" href="/CSS/800.css">
<link rel="stylesheet" type="text/css" media="screen and (max-width: 400px)" href="/CSS/400.css">
	
</head>
<body>
<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/regatta_kopf.php'; 

include_once $_SERVER['DOCUMENT_ROOT'].'/seitenkopf_schreiben_crew.php'; 
?>

<div id="content">
<table class="del_question">
	<tr><td><h1>Teilnehmer löschen?</h1></td></tr>
	<tr><td>Sind Sie sicher, dass Sie diesen Teilnehmer unwiderruflich löschen möchten?</td></tr>
</table>
<?php


debug_to_console("Ende teilnehmer_del_question.php");	
?>
</div>

<section class="navi-articles">

	<article class="box navi">
  		<table align="center">
		  <tr>
		  	<td>
			<a href='/teilnehmer_del.php?loeschen=Loeschen&teilnehmer_id=<?php echo $_GET['teilnehmer_id'];?>'>Ja</a>		
		   </td>
		  </tr>
		</table>
    </article>

	
    <article class="box navi">
          <table align="center"><tr><td>
    	  <a href="/teilnehmerliste.php?regatta_id=<?php echo $_SESSION['sess_regatta_id'] ?>">Nein</a>   
          </td></tr></table>
	</article>						
</section>	

</body>
</html>