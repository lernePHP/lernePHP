<html>
<head>
<?php
//diese php-datei fungiert als Zwischen-Stop, damit der neu eingegebene Teilnehmer in der Teilnehmerliste aktualisiert angezeigt werden kann.

$text="/teilnehmerliste.php?regatta_id=";
$text.=$regatta_id;
?>
<script language="Javascript">
<!--

window.open("<?php echo $text;?>" ,"_self");
location.reload;
header("location:<?php echo $text;?>");
-->
</script>
</head>
<body>
</body>
</html>