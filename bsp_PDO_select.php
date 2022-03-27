
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL SELECT</title>
</head>
<body>

<?php
/***************************************************************************************
*** Basis-Datenbank ist der Scooter-Verleih (localhost/phpmyadmin --> scooterverleih)
****************************************************************************************/

//Datenbank-Verbundung aufbauen.
require_once 'config.php';
require_once 'connection.php';


try {
    //----------------------------------------------------------------------------------------
    //  1) select-Statement mit zu bindenden Parametern
    $sql = "SELECT concat(Person_Nachname, ' ',Person_Vorname) AS Name, Person_Ort FROM `person`
            where Person_Ort = :person_ort
            ORDER BY Name";
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  2) statement vorbereiten
    $stmt = $conn->prepare($sql);
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  3) Parameter binden
    $person_ort = "Wien";
    $stmt->bindParam(':person_ort', $person_ort);
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  4) statement ausführen (binden und ausführen kann auch öfter ausgeführt werde, z.B. zum Einfügen mehrerer Datensätze)
    $stmt->execute();
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  5) Datensätze durchwandern
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Abfrageergebnis auslesen
    echo "<table>";
    foreach($result as $row => $akt_person) {
        //aktuellen Datensatz ansprechen
        echo "<tr>";
            echo "<td>".$akt_person['Name']."<td>";
            echo "<td>".$akt_person['Person_Ort']."<td>";
        echo "</tr>";
    }
    echo "<table>";
    //----------------------------------------------------------------------------------------
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>