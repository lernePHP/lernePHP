<?php
/*
****************************************************************************************
wenn man eine SQL-Abfrage ohne zu bindende Parameter ausführen möchte, 
kann man mit query() prepare und execute in einem ausführen
****************************************************************************************
*/
require_once 'config.php';
require_once 'connection.php';

try {
    $sql = "SELECT Person_Nachname, Person_Vorname FROM person ORDER BY Person_Nachname";
    $result = $conn->query($sql);         //prepare und execute in einem

    //Abfrageergebnis auslesen
    foreach($result as $row => $akt_person) {
        echo $akt_person['Person_Nachname']."<br>";
        echo $akt_person['Person_Vorname']."<br>";
        print_r($akt_person);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL - QUERY</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Bootstrap Ende -->
</head>
<body>
</body>
</html>