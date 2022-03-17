<?php
require_once 'config.php';
require_once 'connection.php';

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

//CHECKING SUBMIT BUTTON PRESS or NOT.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitBtn"]) && $_POST["submitBtn"]!="" && !empty($_POST["submitBtn"])) { 
    //hier wird auf das im html-tag angegebene 'input_Person_Nachname' zugegriffen
    //htmlspecialchars noch einbauen


    isset($_POST["input_Person_Nachname"]) && is_string($_POST["input_Person_Nachname"]) ? $nachname = trim($_POST["input_Person_Nachname"]) : $nachname= "";
    isset($_POST["input_Person_Vorname"]) && is_string($_POST["input_Person_Vorname"]) ? $vorname = trim($_POST["input_Person_Vorname"]) : $vorname= "";
    isset($_POST["input_Person_Strasse"]) && is_string($_POST["input_Person_Strasse"]) ? $strasse = trim($_POST["input_Person_Strasse"]) : $strasse= "";
    isset($_POST["input_Person_PLZ"]) && is_string($_POST["input_Person_PLZ"]) ? $plz = trim($_POST["input_Person_PLZ"]) : $plz= "";
    isset($_POST["input_Person_Ort"]) && is_string($_POST["input_Person_Ort"]) ? $ort = trim($_POST["input_Person_Ort"]) : $ort= "";
    isset($_POST["input_Person_SVNr"]) && is_string($_POST["input_Person_SVNr"]) ? $svnr = trim($_POST["input_Person_SVNr"]) : $svnr= "";
    isset($_POST["input_Person_Email"]) && is_string($_POST["input_Person_Email"]) ? $email = trim($_POST["input_Person_Email"]) : $email= "";

    //auslesen der Checkbox!!!
    //$stammkunde = var_dump(isset($_POST["input_Person_Stammkunde"]));
    $stammkunde = isset($_POST["input_Person_Stammkunde"]) ? 1 : 0;


    isset($_POST["input_Person_Geschlecht"]) ? $geschlecht = $_POST["input_Person_Geschlecht"] : $geschlecht = "";
    isset($_POST["input_Person_Abonnement"]) ? $abo = $_POST["input_Person_Abonnement"] : $abo = "";




    try {
        $stmt = $conn->prepare("INSERT INTO `person` (
            Person_Nachname,
            Person_Vorname,
            Person_Strasse,
            Person_PLZ,
            Person_Ort,
            Person_SVNr,
            Person_Email,
            Person_Stammkunde,
            Person_Geschlecht,
            Person_Abonnement
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
            :person_abonnement
            )
        ");

        $stmt->bindValue(':person_nachname', $nachname);
        $stmt->bindValue(':person_vorname', $vorname);
        $stmt->bindValue(':person_strasse', $strasse);
        $stmt->bindValue(':person_plz', $plz);
        $stmt->bindValue(':person_ort', $ort);
        $stmt->bindValue(':person_svnr', $svnr);
        $stmt->bindValue(':person_email', $email);
        $stmt->bindValue(':person_stammkunde', $stammkunde);
        $stmt->bindValue(':person_geschlecht', $geschlecht);
        $stmt->bindValue(':person_abonnement', $abo);
        
        $stmt->execute();
    
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
    <title>Bootstrap Formular Vorlage</title>

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
    <h2 class="mt-5">Datenerfassung zur Person</h2>
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">       
        <label for="input_Person_Nachname" class="sr-only">Nachname</label>
        <input type="text" name="input_Person_Nachname" id="input_Person_Nachname" class="form-control" placeholder="Nachname" required autofocus>

        <label for="input_Person_Vorname" class="sr-only">Vorname</label>
        <input type="text" name="input_Person_Vorname" id="input_Person_Vorname" class="form-control" placeholder="Vorname">

        <label for="input_Person_Strasse" class="sr-only">Strasse</label>
        <input type="text" name="input_Person_Strasse" id="input_Person_Strasse" class="form-control" placeholder="Straße">

        <label for="input_Person_PLZ" class="sr-only">PLZ</label>
        <input type="text" name="input_Person_PLZ" id="input_Person_PLZ" class="form-control" placeholder="PLZ">

        <label for="input_Person_Ort" class="sr-only">Ort</label>
        <input type="text" name="input_Person_Ort" id="input_Person_Ort" class="form-control" placeholder="Ort">

        <label for="input_Person_SVNr" class="sr-only">SVNr</label>
        <input type="text" name="input_Person_SVNr" id="input_Person_SVNr" class="form-control" placeholder="SVNr">

        <label for="input_Person_Email" class="sr-only">Email-Adresse</label>
        <input type="email" name="input_Person_Email" id="input_Person_Email" class="form-control" placeholder="Email-Adresse">


        <div class="checkbox mt-5">
            <input type="checkbox" id="input_Person_Stammkunde" name="input_Person_Stammkunde" value="1">
            <label for="input_Person_Stammkunde">Stammkunde</label>
        </div>

        <h4 class="mt-5">Geschlecht</h4>
        <div class="form-check">
                <input id="input_Person_Geschlecht_keineAngabe" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="-" checked required>
                <label class="form-check-label" for="input_Person_Geschlecht_keineAngabe">keine Angabe</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_weiblich" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="w" required>
            <label class="form-check-label" for="input_Person_Geschlecht_weiblich">weiblich</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_maennlich" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="m" required>
            <label class="form-check-label" for="input_Person_Geschlecht_maennlich">männlich</label>
        </div>
        <div class="form-check">
            <input id="input_Person_Geschlecht_divers" name="input_Person_Geschlecht" type="radio" class="form-check-input" value="d" required>
            <label class="form-check-label" for="input_Person_Geschlecht_divers">divers</label>
        </div>

        <h4 class="mt-5">Abonnement</h4>
        <label for="input_Person_Abonnement" class="form-label">Abonnement</label>
        <select class="form-select" id="input_Person_Abonnement" name="input_Person_Abonnement" required>
            <option value="">Wähle ...</option>
            <option value="klein">klein</option>
            <option value="mittel">mittel</option>
            <option value="groß">groß</option>
        </select>
        <div class="invalid-feedback">
        Bitte wählen sie ein gültiges Abonnement.
        </div>

      <input name="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit" id="submitBtn" value="Anmelden"></button>
    </form>
  </div> <!-- /container -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>