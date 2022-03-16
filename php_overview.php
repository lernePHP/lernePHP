
<?php
/***************************************************************************************
*** Basis-Datenbank ist der Scooter-Verleih (localhost/phpmyadmin --> scooterverleih)
****************************************************************************************/

//Datenbank-Verbundung aufbauen.
//Achtung: 
//Konfigurationsdaten wie Datenbankserver, Datenbankname, Benutzername und Passwort 
//zuvor in config.php einrichten
require_once 'config.php';
require_once 'connection.php';


//----------------------------------------------------------------------------------------
//ein einfaches Select-Statement
$sql = "SELECT `Person_Nachname`, `Person_Vorname` FROM `person`\n"
    . "ORDER BY `Person_Nachname`;";

//Statement abschicken und Ergebnis in result speichern
$result = mysqli_query($conn, $sql);

//einfache Ausgabe der gefundenen Zeilen
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["Person_Nachname"]." ".$row["Person_Vorname"]."<br>";
    }
}
//----------------------------------------------------------------------------------------
echo "<br>";


//----------------------------------------------------------------------------------------
//ein etwas komplizierteres Select-Statement mit WHERE und JOINS

$sql = "SELECT `v`.`VerleihAmUm`, `s`.`Scooter_Seriennummer`, `s`.`Scooter_Farbe`, `s`.`Scooter_Baujahr`, concat(Person_Nachname, \" \",Person_Vorname) AS Name\n"

    . "FROM `verleih` AS `v` \n"

    . "    INNER JOIN `verleihposition` AS `vp` ON `vp`.`Verleih_id` = `v`.`Verleih_Id` \n"

    . "    INNER JOIN `scooter` AS `s` ON `vp`.`Scooter_id` = `s`.`Scooter_Id`\n"

    . "    INNER JOIN person as p on v.Person_Id = p.Person_Id\n"

    . "WHERE date(v.VerleihAmUm)=\"2022-03-13\"\n"

    . "ORDER BY Scooter_Baujahr;";
$result = mysqli_query($conn, $sql);

//einfache Ausgabe der gefundenen Zeilen
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["VerleihAmUm"]." ".$row["Scooter_Seriennummer"]." ".$row["Scooter_Farbe"]." ".$row["Scooter_Baujahr"]." ".$row["Name"]."<br>";
    }
}
//----------------------------------------------------------------------------------------


/* das müssen wir auskommentieren, sonst wird bei jedem Aufruf versucht, diesen
// Datensatz einzufügen, das führt wegen doppelter Einträge zu fehlern.
//----------------------------------------------------------------------------------------
//Insert-Statement
$sql = "INSERT INTO `person`(`Person_Nachname`, `Person_Vorname`, `Person_Strasse`, `Person_PLZ`, `Person_Ort`, `Person_SVNr`, `Person_Email`) \n"
    ."  VALUES ('Hauser','Anna','Buxdehude 1','A-5864','Buxdehude','1112250280','anna.hauser@gmail.com')";

//Statement abschicken
//$result ist true, falls das Insert erfolgreich war
$result = mysqli_query($conn, $sql);
//----------------------------------------------------------------------------------------
*/


//----------------------------------------------------------------------------------------
//Update-Statement
$sql = "UPDATE `scooter` SET `Scooter_Baujahr`= `Scooter_Baujahr` + 1 \n"

    . "WHERE `Scooter_Baujahr` = 2023;";

//Update-Statement abschicken
$result = mysqli_query($conn, $sql);
//----------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------
//Delete-Statement
$sql = "DELETE FROM `person` WHERE `person`.`Person_Id` = 7";

//Delete-Statement abschicken
$result = mysqli_query($conn, $sql);
//----------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------
//und jetzt noch ein etwas komplizierteres Delete-Statement mit WHERE
$sql = "DELETE FROM `person` WHERE (`Person_Nachname`= 'Zauner' AND `Person_Vorname`= 'Harald') OR (`Person_Nachname`= 'Hauser' AND `Person_Vorname`= 'Andrea')";
$result = mysqli_query($conn, $sql);
//----------------------------------------------------------------------------------------
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hier werden die grundsätzlichen Php-Aktionen harcodiert ausgeführt.</h1>
</body>
</html>