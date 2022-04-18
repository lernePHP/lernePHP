<?php

//schützt vor böswilligen User-Eingaben. "<" wird z.B. in "&lt;" umgewandelt.
//normaler Text bleibt gleich.
//htmlentities() und htmlspecialchars() kann beides verwendet werden. htmlentities kodiert mehr.
$vorname = htmlentities($_POST["vorname"]);
//die andere Richtung: html_entity_decode()
//---------


//eingegebene Zahlen müssen als Zahl umgewandelt werden
//durch das Umwandeln verhindert man auch die Übermittlung schädlicher Eingaben
$zahl_converted = intval($_POST("zahl")); 
$zahl_converted2 = floatval($_POST("zahl"));
$zahl_converted3 = doubleval($_POST("zahl"));


//mit strval() können Zahlen explizit in einen String umgewandelt werden
$str_converted = strval($_POST("zahl")); 

//mit isset($variable) kann die existenz einer Variable überprüft werden
?>