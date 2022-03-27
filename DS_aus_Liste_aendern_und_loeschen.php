<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datensatz aus Liste löschen</title>

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
    <h2 class="mt-5">Datensatz aus Liste ändern</h2>
    <table class="table">
        <?php
        //Datenbank-Verbundung aufbauen.
        require_once 'config.php';
        require_once 'connection.php';


        try {
            //----------------------------------------------------------------------------------------
            //  1) select-Statement mit zu bindenden Parametern
            $sql = "SELECT person_id, concat(Person_Nachname, ' ',Person_Vorname) AS Name, Person_Ort FROM `person`
                    ORDER BY Name";
            //----------------------------------------------------------------------------------------


            $result = $conn->query($sql);         //prepare und execute in einem

            //Abfrageergebnis auslesen
            foreach($result as $row => $akt_person) {
                //aktuellen Datensatz ansprechen
                echo "<tr>";
                    echo "<td>".$akt_person['person_id']."<td>";
                    echo "<td>".$akt_person['Name']."<td>";
                    echo "<td>".$akt_person['Person_Ort']."<td>";

                    //nur zur allgemeinen Doku, wie es mit 2 Get-Parametern funktionieren würde
                    $erst_aufruf = 1;
                    echo "<td><a href='/lernePhp/person_admin.php?person_id=".$akt_person["person_id"]."&erst_aufruf=1'>ändern</a></td>";
                    echo "<td><a href='/lernePhp/person_del.php?person_id=".$akt_person["person_id"]."'>löschen</a></td>";
                echo "</tr>";
            }
            //----------------------------------------------------------------------------------------
        }
        catch(PDOException $e) {
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