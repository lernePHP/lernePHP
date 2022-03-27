<?php
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
    $person_id = $_GET['person_id'];
    $stmt->bindParam(':person_id', $person_id);
    //----------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------
    //  4) statement ausführen (binden und ausführen kann auch öfter ausgeführt werde, z.B. zum Einfügen mehrerer Datensätze)
    $stmt->execute();
    //----------------------------------------------------------------------------------------


    $header_text= "location:http://".$_SERVER['SERVER_NAME']."/lernePHP/DS_aus_Liste_aendern.php";
    header($header_text);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>