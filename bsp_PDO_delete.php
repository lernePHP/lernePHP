
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL - DELETE</title>
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
    $sql = "DELETE FROM `person` WHERE Person_Id = :person_id";
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  2) statement vorbereiten
    $stmt = $conn->prepare($sql);
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  3) Parameter binden
    $person_id = 25;
    $stmt->bindParam(':person_id', $person_id);
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  4) statement ausführen (binden und ausführen kann auch öfter ausgeführt werde, z.B. zum Einfügen mehrerer Datensätze)
    $stmt->execute();
    //----------------------------------------------------------------------------------------
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>