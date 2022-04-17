<?php
//--------------------------------------
//Erweiterung Nov17 ok
//---------------------------------------

//functions.php enthält allgemeine php-Funktionen, u.a. eine,um via php in die Browser-Console von Firefox zu schreiben
//der Aufruf dafür wäre:
include_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
debug_to_console("Hallo in alle_rechnungen_aufruf.php");

header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
<title>Verwalten einer Regatta</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; ?>
<!--<link href="/CSS/styles.css" rel="stylesheet" type="text/css">-->
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">	
<script src="/functions.js" type="text/javascript"></script>
</head>
<?php
//wenn keine id übergeben wurde, dann die
if (!$_GET['regatta_id']) die;
$regatta_id=$_GET['regatta_id'];
?>
<body onBlur=window.close()>
<div id="content_frei">

<?php
//connection.php includieren
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

//sql-Statement erstellen
$sql_TN="SELECT Count(*) FROM tbl_teilnehmer_boot ";
$sql_TN.="WHERE ((regatta_fid=".$regatta_id.") && (restzahlung_verschickt = 0) && (Barzahlung = 0) && (nenngeld_befreiung = 0)) ORDER BY nachname,vorname";

$statement = $mydb->prepare($sql_TN);
if ($statement->execute()) {
	$anz_DS = $statement->fetchcolumn();
}	
	

if ($anz_DS==0)
{
?>
<table>
	<tr>
		<td>
        	Es sind keine Abschluss-Rechnungen für diese Regatta offen.
		</td>
	</tr>
    <tr>
    	<td>
        	<a href="" onClick="window.close()">OK</a>
        </td>
    </tr>
</table>
<?php
}
else
{
?>
<table>
	<tr>
    	<td>
        	Sind Sie sicher, dass Sie <strong>jetzt</strong> automatisch alle Folgerechnungen dieser Regatta erstellen und versenden wollen? (Anzahl der Rechnungen: <?php echo $anz_DS?>).
            <br />
            Dieser Vorgang kann nicht mehr rückgängig gemacht werden!<br />        
        <td>
    </tr>
	<tr>
    	<td>
			<a href="/alle_rechnungen_pdf.php?regatta_id=<?php echo $regatta_id;?>">Rechnungen jetzt erstellen und versenden</a>
        </td>
        
        <td>
        	<a href="" onClick="window.close()">Abbrechen</a>
        </td>
    </tr>
</table>
<?php }		//Ende IF?>

</body>
</html>