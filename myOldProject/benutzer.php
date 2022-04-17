<?php
header("Content-Type: text/html; charset=utf-8");

session_start();
?>
<html>
<head>
<?php include $_SERVER['DOCUMENT_ROOT'].'/meta.php'; 		//Zeichencodierung und css definieren ?>
<link href="/CSS/styles.css" rel="stylesheet" type="text/css">

</head>
<body>
<table>

<tr>
<td>
benutzerrechte: <?php echo $_SESSION['sess_login_rechte'];?>
</td>
</tr>

<tr>
<td>
teilnehmer_id: <?php echo $_SESSION['sess_login_teilnehmer_id'];?>
</td>
</tr>

</table>
</body>
</html>