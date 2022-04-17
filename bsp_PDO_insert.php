<?php
require_once 'config.php';
require_once 'connection.php';

//hartcodiert, d.h. der Aufruf von bsp_PDO_select.php funktioniert so genau EINMAL
//danach verursachen diese Werte einen fehler, weil manche doppelten Werte nicht erlaubt sind.
$nachname ="Müller";
$vorname = "Hans";
$strasse = "Buxdehude 1";
$plz = "A-1010";
$ort = "Wien";
$svnr = "4532240202";
$email = "hans.mueller@gmail.com";
$stammkunde = "1";
$geschlecht = "m";
$abo = "klein";
$pwd = "max";


try {
    //----------------------------------------------------------------------------------------
    //  1) sql-Anweisung
    //  sql-Anweisung mit zu bindenden Parametern für das prepare-Statement
    //  prepare-Statements sind wichtig, um SQL-Injection vorzubeugen
    $sql = "
    INSERT INTO `person` (
        Person_Nachname,
        Person_Vorname,
        Person_Strasse,
        Person_PLZ,
        Person_Ort,
        Person_SVNr,
        Person_Email,
        Person_Stammkunde,
        Person_Geschlecht,
        Person_Abonnement,
        Person_Passwort
        )
        VALUES (
        :person_nachname, 
        :person_vorname, 
        :person_strasse, 
        :person_plz, 
        :person_ort, 
        :person_svnr, 
        :person_email, 
        :person_stammkunde,
        :person_geschlecht, 
        :person_abonnement,
        :person_passwort
        )
    ";
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  2) statement vorbereiten
    $stmt = $conn->prepare($sql);


    //----------------------------------------------------------------------------------------
    //  3) Parameter binden
    $stmt->bindParam(':person_nachname', $nachname);
    $stmt->bindParam(':person_vorname', $vorname);
    $stmt->bindParam(':person_strasse', $strasse);
    $stmt->bindParam(':person_plz', $plz);
    $stmt->bindParam(':person_ort', $ort);
    $stmt->bindParam(':person_svnr', $svnr);
    $stmt->bindParam(':person_email', $email);
    $stmt->bindParam(':person_stammkunde', $stammkunde);
    $stmt->bindParam(':person_geschlecht', $geschlecht);
    $stmt->bindParam(':person_abonnement', $abo);
    $stmt->bindParam(':person_passwort', $pwd);
    

    //----------------------------------------------------------------------------------------
    //  4) statement ausführen (binden und ausführen kann auch öfter ausgeführt werde, z.B. zum Einfügen mehrerer Datensätze)
    $stmt->execute();


    //----------------------------------------------------------------------------------------
    //  5) auf die ID des gerade eingefügten Datensatzes zugreifen
    echo "Id des eingefügten Datensatzes: ".$conn->lastInsertId()."<br>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL - INSERT</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Bootstrap Ende -->
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>