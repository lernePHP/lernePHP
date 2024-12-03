<?php
// aktuell funktioniert dieses Skript noch nicht so, wie es soll.
// Etwaige Änderungen werden nicht in die DB geschrieben.
// Das Skript wird demnächst überarbeitet.
//echo $_GET['person_id'];

require_once 'config.php';
require_once 'connection.php';


//Aufruf z.B.: person_admin?person_id=23
$person_id = $_GET['person_id'];
$nachname ="";
$vorname = "";
$strasse = "";
$plz = "";
$ort = "";
$svnr = "";
$email = "";
$stammkunde = "";
$geschlecht = "";
$abo = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitBtn"]) && $_POST["submitBtn"]!="" && !empty($_POST["submitBtn"])) {
    // es wurde auf SPEICHERN gedrückt. Die Änderungen müssen in die Datenbank geschrieben werden, 
    // bevor die aktualisierten Daten in das Formular eingetragen werden

    $nachname       = $_POST['input_Person_Nachname'];
    $vorname        = $_POST['input_Person_Vorname'];
    $strasse        = $_POST['input_Person_Strasse'];
    $plz            = $_POST['input_Person_PLZ'];
    $ort            = $_POST['input_Person_Ort'];
    $svnr           = $_POST['input_Person_SVNr'];
    $email          = $_POST['input_Person_Email'];
    $stammkunde     = $_POST['input_Person_Stammkunde'];
    $geschlecht     = $_POST['input_Person_Geschlecht'];
    $abo            = $_POST['input_Person_Abonnement'];


    $sql = "UPDATE person SET 
                Person_Nachname = :person_nachname, 
                Person_Vorname  = :person_vorname,
                Person_Strasse  = :person_strasse,
                Person_PLZ      = :person_plz,
                Person_Ort      = :person_ort,
                Person_SVNr     = :person_svnr,
                Person_Email    = :person_email,
                Person_Stammkunde   = :person_stammkunde,
                Person_Geschlecht   = :person_geschlecht,
                Person_Abonnement   = :person_abonnement
            WHERE person_id = ".$person_id;

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
    
    //----------------------------------------------------------------------------------------
    //  4) statement ausführen (binden und ausführen kann auch öfter ausgeführt werde, z.B. zum Einfügen mehrerer Datensätze)
    try {
        $stmt->execute(); 
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }           
}
else {
    // beim Aufruf der Seite direkt oder von einer anderen Seite aus, nicht aber über den SPEICHERN Button
    // Person via GET-Parameter person_id aus der DB suchen und die zugehörigen Daten ins Formular schreiben
    try {
        //----------------------------------------------------------------------------------------
        //  1) select-Statement mit zu bindenden Parametern
        $sql = "SELECT * FROM `person`
                WHERE person_id = ".$person_id;
        //----------------------------------------------------------------------------------------


        $result = $conn->query($sql);         //prepare und execute in einem

        //Abfrageergebnis auslesen
        foreach($result as $row => $akt_person) {
            //aktuellen Datensatz ansprechen
            $nachname = $akt_person['Person_Nachname'];
            $vorname = $akt_person['Person_Vorname'];
            $strasse = $akt_person['Person_Strasse'];
            $plz = $akt_person['Person_PLZ'];
            $ort = $akt_person['Person_Ort'];
            $svnr = $akt_person['Person_SVNr'];
            $email = $akt_person['Person_Email'];
            $stammkunde = $akt_person['Person_Stammkunde'];
            $geschlecht = $akt_person['Person_Geschlecht'];
            $abo = $akt_person['Person_Abonnement'];
        }
        //----------------------------------------------------------------------------------------
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person verwalten</title>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Bootstrap Ende -->

    <script type="text/javascript">
        function checkForm()
        //bevor diese Funktion ausgeführt wird, werden die required autofocus evaluiert. 
        //also Evaluierung ENTWEDER hier ODER mit required autofocus
        {
            var err_msg;
            var err_vorname;
            var err_svnr;

            err_msg = "";
            err_vorname = "\n Geben Sie bitte einen Vornamen ein.";
            err_svnr = "Geben Sie eine gültige Sozialversicherungsnummer ein!";

            if (document.person_register.input_Person_Vorname.value == "")
            {
                err_msg = err_vorname;
                document.person_register.input_Person_Vorname.focus();
                alert(err_msg);
				return false;
            }

            
            if (!isValidSVNR(document.person_register.input_Person_SVNr.value)) {
                err_msg = err_svnr;
                document.person_register.input_Person_SVNr.focus();
                alert(err_msg);
				return false;               
            }
            

            return true;
        }

        
        function isValidSVNR(svnr)
        {
            console.log("in isValidSVNR");
            //------------------
            //Länge überprüfen
            if (svnr.length != 10) {
                console.log("Anzahl Stellen ist nicht 10");
                return false;
            }
            //------------------


            let pz_errechnet;
            let pz;
            pz_errechnet = 0;
            pz = 0;
            for (let i = 1; i <= 10; i++) {
                //überprüfen, ob es eine Zahl ist
                console.log("i: " + i.toString());
                if (isNaN(Number(svnr.substr(i, 1)))) {
                    return false;
                }

                //die jeweilige Stelle ist eine Zahl. Jetzt kanns weitergehen
                switch(i) {
                    case 1:
                        pz_errechnet = pz_errechnet + 3 * Number(svnr.substr(i-1, 1));
                        break;
                    case 2:
                        pz_errechnet = pz_errechnet + 7 * Number(svnr.substr(i-1, 1));
                        break;
                    case 3:
                        pz_errechnet = pz_errechnet + 9 * Number(svnr.substr(i-1, 1));
                        break;
                    case 4:
                        pz = Number(svnr.substr(i-1, 1));
                        break;
                    case 5:
                        pz_errechnet = pz_errechnet + 5 * Number(svnr.substr(i-1, 1));
                        break;
                    case 6:
                        pz_errechnet = pz_errechnet + 8 * Number(svnr.substr(i-1, 1));
                        break;                                                
                    case 7:
                        pz_errechnet = pz_errechnet + 4 * Number(svnr.substr(i-1, 1));
                        break;
                    case 8:
                        pz_errechnet = pz_errechnet + 2 * Number(svnr.substr(i-1, 1));
                        break;
                    case 9:
                        pz_errechnet = pz_errechnet + 1 * Number(svnr.substr(i-1, 1));
                        break;
                    case 10:
                        pz_errechnet = pz_errechnet + 6 * Number(svnr.substr(i-1, 1));
                        break;                                                
                    default:
                        // code block
                }
            }
            
            pz_errechnet = pz_errechnet % 11;

            if (pz != pz_errechnet) {
                return false;
            }
            
            return true;   
        }        

        function getSVNrImg()
        {
            //<img src="images/valid.png" alt="valid" height="100">
            return "valid.png";
        }
    </script>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Verwalten der Persondaten</h2>
    <form class="form-signin" onSubmit="return checkForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?person_id=$person_id");?>" method="post" name="person_admin">       
        <label for="input_Person_Nachname" class="sr-only">Nachname</label>
        <input type="text" name="input_Person_Nachname" id="input_Person_Nachname" value = <?php echo "'".$nachname."'"?> class="form-control" placeholder="Nachname" required autofocus>

        <label for="input_Person_Vorname" class="sr-only">Vorname</label>
        <input type="text" name="input_Person_Vorname" id="input_Person_Vorname" value = <?php echo "'".$vorname."'"?> class="form-control" placeholder="Vorname">

        <label for="input_Person_Strasse" class="sr-only">Strasse</label>
        <input type="text" name="input_Person_Strasse" id="input_Person_Strasse" value = <?php echo "'".$strasse."'"?> class="form-control" placeholder="Straße">

        <label for="input_Person_PLZ" class="sr-only">PLZ</label>
        <input type="text" name="input_Person_PLZ" id="input_Person_PLZ" value = <?php echo "'".$plz."'"?> class="form-control" placeholder="PLZ">

        <label for="input_Person_Ort" class="sr-only">Ort</label>
        <input type="text" name="input_Person_Ort" id="input_Person_Ort" value = <?php echo "'".$ort."'"?> class="form-control" placeholder="Ort">

        <label for="input_Person_SVNr" class="sr-only">SVNr</label> 
        <input type="text" name="input_Person_SVNr" id="input_Person_SVNr" value = <?php echo "'".$svnr."'"?> class="form-control" placeholder="SVNr" required autofocus> 

        <label for="input_Person_Email" class="sr-only">Email-Adresse</label>
        <input type="email" name="input_Person_Email" id="input_Person_Email" value = <?php echo "'".$email."'"?> class="form-control" placeholder="Email-Adresse" required>


        <div class="checkbox mt-5">
            <input type="checkbox" id="input_Person_Stammkunde" name="input_Person_Stammkunde" value="1" 
                <?php 
                if ($stammkunde) {
                    echo "checked";
                }    
                ?>
            >
            <label for="input_Person_Stammkunde">Stammkunde</label>
        </div>

        <h4 class="mt-5">Geschlecht</h4>
        <div class="form-check">
            <input id="input_Person_Geschlecht_keineAngabe" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="-" required
                <?php
                if ($geschlecht == "-"){
                    echo "checked";
                }
                ?>
            >
            <label class="form-check-label" for="input_Person_Geschlecht_keineAngabe">keine Angabe</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_weiblich" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="w" required
                <?php
                if ($geschlecht == "w"){
                    echo "checked";
                }
                ?>
            >
            <label class="form-check-label" for="input_Person_Geschlecht_weiblich">weiblich</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_maennlich" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="m" required
                <?php
                if ($geschlecht == "m"){
                    echo "checked";
                }
                ?>
            >
            <label class="form-check-label" for="input_Person_Geschlecht_maennlich">männlich</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_divers" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="d" required
                <?php
                if ($geschlecht == "d"){
                    echo "checked";
                }
                ?>
            >
            <label class="form-check-label" for="input_Person_Geschlecht_divers">divers</label>
        </div>

        <h4 class="mt-5">Abonnement</h4>
        <label for="input_Person_Abonnement" class="form-label">Abonnement</label>
        <select class="form-select" id="input_Person_Abonnement" name="input_Person_Abonnement" required>
            <option value="">Wähle ...</option>
            <option value="klein" 
                <?php
                 if ($abo == "klein"){
                    echo "selected";
                }               
                ?>
            >klein</option>
            <option value="mittel"
                <?php
                 if ($abo == "mittel"){
                    echo "selected";
                }               
                ?>
            >mittel</option>
            <option value="groß"
                <?php
                 if ($abo == "groß"){
                    echo "selected";
                }               
                ?>
            >groß</option>
        </select>

      <input name="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit" id="submitBtn" value="Speichern"></button>
    </form>
  </div> <!-- /container -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>