<?php

//diese Funktion schreibt in die Browser-Console von Firefox.
//Wichtig! Browser Console, NICHT Web Console
function debug_to_console($data) {
	/*
	if(is_array($data) || is_object($data)) { 	
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
	*/
}

//-------

function write_to_logfile($text='') {
    /*
     * damit kann ich jeden beliebnigen Text in das Textfile errorfile.txt schreiben.
     * Damit kann ich ohne echo-Anweisungen Fehler schreiben, unabhängig von header-Anweisungen.
     * In der echten Umgebung kommentiere ich den Inhalt dieser Funktion standardmäßig aus, damit das File nicht zu groß wird.
     * In der Entwicklungsumgebung kann ich es auskommentiert lassen.
     * 
     * Diese Funktion schreibt den übergebenen Text mit einem Zeitstempel in eine Zeile und macht dann einen Zeilenumbruch.
     */
    $fp = fopen("logfile.txt", "a");
    
    $time_stamp = date("h:i:s d:m.Y");
    $log_text=$time_stamp . $text . "\r\n";
    
    fwrite($fp, $log_text);
    fclose($fp);
}

function exception_handler($exception) {
	echo '<html>';
	echo '<head>';
	echo '<title>Error</title>';

	//bootstrap_include.php includieren
	include $_SERVER['DOCUMENT_ROOT'].'/bootstrap_include.php';	

	echo '</head>';
	echo '<body>';	
	echo '<div class="alert alert-danger">';
	echo '<b>Fatal error</b>:  Uncaught exception \'' . get_class($exception) . '\' with message ';
	echo $exception->getMessage() . '<br>';
	echo 'Stack trace:<pre>' . $exception->getTraceAsString() . '</pre>';
	echo 'thrown in <b>' . $exception->getFile() . '</b> on line <b>' . $exception->getLine() . '</b><br>';
	echo '</div>';
	echo '</body>';
	echo '</html>';
}
?>