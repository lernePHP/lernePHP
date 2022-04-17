<?php
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/javascript');
    
	//connection.php includieren
	include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

    $regatta = $_GET[regatta];
    $group = $_GET[group];
    $callback = $_GET[callback];
    
    echo $callback;
    echo "({\"boots\":[";

    $i=0;


    $sql = "select * from tbl_teilnehmer_boot where regatta_fid = '$regatta' and gruppen_fid = '$group' order by teilnehmer_id";	
	$statement = $mydb -> prepare($sql);
	if ($statement->execute()) {}


	while ($akt_zeile=$statement->fetch()) {	
        if($i > 0) echo ",";
        $i++;
        echo "{\"nachname\":\"".$akt_zeile[Nachname]."\",\"vorname\":\"".$akt_zeile[Vorname]."\",\"bootstyp\":\"".$akt_zeile[Bootstype]."\",\"bootsname\":\"".$akt_zeile[bootsname]."\",\"startnummer\":\"".$akt_zeile[startnummer]."\",\"staatsbuergerschaft\":\"".$akt_zeile[staatsbuergerschaft]."\",\"land\":\"".$akt_zeile[Land]."\"}";
    }

    echo "]})";


?>