<?php
    require_once 'config.php';
    require_once 'connection.php';

    $person_id =0;
    $search_parameter = "";

    //CHECKING SUBMIT BUTTON PRESS or NOT.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitBtn"]) && $_POST["submitBtn"]!="" && !empty($_POST["submitBtn"])) { 
        isset($_POST["person_id"])? $person_id = $_POST["person_id"] : $person_id= 0;
        isset($_POST["search_parameter"]) ? $search_parameter = $_POST["search_parameter"] : $search_parameter= "";
    }

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verleih Suche</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Bootstrap Ende -->
</head>
<body>


<div class="container">
    <h2 class="mt-5">Verleih-Vorgänge</h2>
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h4 class="form-signin-heading mt-5">Suche:</h4>

        <label for="person_id" class="form-label mt-3">Person</label>
        <select class="form-select is-invalid" id="person_id" name="person_id" required>
            <option selected disabled value="">Choose...</option>
            <?php
                try {
                    $sql = "SELECT Person_Id, concat(Person_Nachname, ' ',Person_Vorname) AS Name FROM `person`
                    ORDER BY Name";

                    $result = $conn->query($sql);         //prepare und execute in einem
                
                    //Abfrageergebnis auslesen
                    foreach($result as $row => $akt_person) {
                        echo "<option value=".$akt_person['Person_Id'].">".$akt_person['Name']."</option>";
                    }
                
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>
        </select>
            <!-- invalid-feedback funktioniert bei select in Kombination mit Bootstrap leider nicht. Das dürfte in Bootstrap-Bug sein! -->
        <div id="person_idFeedback" class="invalid-feedback">
        Bitte wählen Sie einen gültigen Teilnehmer aus der Liste.
        </div>

        <div class="form-check">
                <input id="all" name="search_parameter" value="all" type="radio" class="form-check-input" checked required>
                <label class="form-check-label" for="all">alle</label>
        </div>
        <div class="form-check">
            <input id="current_month" name="search_parameter" value="current_month" type="radio" class="form-check-input" required>
            <label class="form-check-label" for="current_month">aktueller Monat</label>
        </div>
        <div class="form-check">
            <input id="next_month" name="search_parameter" value="next_month" type="radio" class="form-check-input" required>
            <label class="form-check-label" for="next_month">nächster Monat</label>
        </div>

      <input name="submitBtn" class="btn btn-lg btn-primary btn-block mt-5" type="submit" id="submitBtn" value="Suchen"></button>
    </form>


    <!-- Suchergebnis anzeigen -->
    <h4 class="form-signin-heading mt-5">Sucheergebnis</h4>
    <table class="table mt-3">
        <?php
        try {

            switch ($search_parameter) {
                case "all":
                    //alle Verleihpositionen der eingegebenen Person
                    $sql = "SELECT `VerleihAmUm`, concat(Person_Nachname, ' ',Person_Vorname) AS Name, `Scooter_Seriennummer`, `Scooter_Farbe`, `Scooter_Baujahr`
                            FROM `verleih` AS `v` 
                                INNER JOIN `verleihposition` AS `vp` ON `vp`.`Verleih_id` = `v`.`Verleih_Id` 
                                INNER JOIN `scooter` AS `s` ON `vp`.`Scooter_id` = `s`.`Scooter_Id`
                                inner join person as p on v.Person_Id = p.Person_Id
                            WHERE v.Person_Id = :person_id
                            ORDER BY VerleihAmUm";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':person_id', $person_id);
                    break;
                case "current_month":
                    //Verleihpositionen des aktuellen Monats der eingegebenen Person
                    $sql = "SELECT `VerleihAmUm`, concat(Person_Nachname, ' ',Person_Vorname) AS Name, `Scooter_Seriennummer`, `Scooter_Farbe`, `Scooter_Baujahr`
                            FROM `verleih` AS `v` 
                                INNER JOIN `verleihposition` AS `vp` ON `vp`.`Verleih_id` = `v`.`Verleih_Id` 
                                INNER JOIN `scooter` AS `s` ON `vp`.`Scooter_id` = `s`.`Scooter_Id`
                                inner join person as p on v.Person_Id = p.Person_Id
                            WHERE v.Person_Id = :person_id AND month(v.VerleihAmUm) = month(now())
                            ORDER BY VerleihAmUm";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':person_id', $person_id);
                    break;
                case "next_month":
                    //Verleihpositionen des nächsten Monats der eingegebenen Person
                    $sql = "SELECT `VerleihAmUm`, concat(Person_Nachname, ' ',Person_Vorname) AS Name, `Scooter_Seriennummer`, `Scooter_Farbe`, `Scooter_Baujahr`
                            FROM `verleih` AS `v` 
                                INNER JOIN `verleihposition` AS `vp` ON `vp`.`Verleih_id` = `v`.`Verleih_Id` 
                                INNER JOIN `scooter` AS `s` ON `vp`.`Scooter_id` = `s`.`Scooter_Id`
                                inner join person as p on v.Person_Id = p.Person_Id
                            WHERE v.Person_Id = :person_id AND month(v.VerleihAmUm) > month(now())
                            ORDER BY VerleihAmUm";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':person_id', $person_id);

                    break;
                default:
                    //default = alle anzeigen
                    $sql = "SELECT `VerleihAmUm`, concat(Person_Nachname, ' ',Person_Vorname) AS Name, `Scooter_Seriennummer`, `Scooter_Farbe`, `Scooter_Baujahr`
                            FROM `verleih` AS `v` 
                                INNER JOIN `verleihposition` AS `vp` ON `vp`.`Verleih_id` = `v`.`Verleih_Id` 
                                INNER JOIN `scooter` AS `s` ON `vp`.`Scooter_id` = `s`.`Scooter_Id`
                                inner join person as p on v.Person_Id = p.Person_Id
                            ORDER BY VerleihAmUm";

                    $stmt = $conn->prepare($sql);
                    break;

            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Abfrageergebnis auslesen
            foreach($result as $row => $akt_verleihposition) {
                //HTML-Zeile und Zellen drucken
                echo "<tr>";
                    echo "<td>".$akt_verleihposition['VerleihAmUm']."<td>";
                    echo "<td>".$akt_verleihposition['Name']."<td>";
                    echo "<td>".$akt_verleihposition['Scooter_Seriennummer']."<td>";
                    echo "<td>".$akt_verleihposition['Scooter_Baujahr']."<td>";
                echo "</tr>";
            }

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }        
        ?>
    </table>
</div> <!-- /container -->



  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>