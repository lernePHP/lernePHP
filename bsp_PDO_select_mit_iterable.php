<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        echo "<table style='border: solid 1px black;'>";
        echo "<tr><th>Firstname</th><th>Lastname</th></tr>";

        require_once 'config.php';
        require_once 'connection.php';

        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
              parent::__construct($it, self::LEAVES_ONLY);
            }
          
            function current() {
                //das hier ist jeweils ein Feld. parent::current() gibt den Feldinhalt aus.
                //welche Spalten, das wird durch das sql-Statement bestimmt
              return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
            }
          
            function beginChildren() {
              echo "<tr>";
            }
          
            function endChildren() {
              echo "</tr>" . "\n";
            }
        }

        try {
            $sql = "SELECT person_nachname, person_vorname FROM person 
                    ORDER BY person_nachname ASC, person_vorname ASC";


            //das nur verwenden, wenn ein zu bindender Parameter in der Abfrage vorkommt
            $stmt = $conn->prepare($sql);

            //bindparam()
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
              }

            $conn = null;
            echo "</table>";
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>
</body>
</html>