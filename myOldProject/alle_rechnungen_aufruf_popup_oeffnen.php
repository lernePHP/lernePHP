<?php
//$att="resizable=yes,width=800,height=600,screenX=300,screenY=300";
//screenX und screenY steht im IE nicht zur Verfügung und führt zu einem Fehler
$att="resizable=yes,width=800,height=100,left=400,top=300";
$fenster="/alle_rechnungen_aufruf.php?regatta_id=".$regatta_id;
$onclick="";
$onclick.="fenster_oeffnen(this.href";
$onclick.=", '";
$onclick.=$att;
$onclick.="'";
$onclick.=")";
$onclick.="; return false";
//echo "<br> \$onclick: ".$onclick."<br>";
?>
<a href="<?php echo $fenster; ?>" target="_blank" onClick="<?php echo $onclick; ?>">Abschluss-Rechnungen aller Teilnehmer jetzt erstellen und versenden</a>
