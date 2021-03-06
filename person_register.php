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
            //console.log("in isValidSVNR");
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
        
        function setImgSrc()
        {
            /*
                /   = Root directory
                .   = This location
                ..  = Up a directory
                ./  = Current directory
                ../ = Parent of current directory
                ../../ = Two directories backwards
            */
            if (isValidSVNR(document.person_register.input_Person_SVNr.value)) {
                document.getElementById("svnrImg").src = "./images/valid.png";
            }
            else {
                document.getElementById("svnrImg").src = "./images/notvalid.png";
            }
        }
    </script>
</head>
<body>
    <div class="container">
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
    $pwd = "";

    //CHECKING SUBMIT BUTTON PRESS or NOT.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitBtn"]) && $_POST["submitBtn"]!="" && !empty($_POST["submitBtn"])) { 

        isset($_POST["input_Person_Nachname"]) && is_string($_POST["input_Person_Nachname"]) ? $nachname = trim(htmlentities($_POST["input_Person_Nachname"])) : $nachname= "";
        isset($_POST["input_Person_Vorname"]) && is_string($_POST["input_Person_Vorname"]) ? $vorname = trim(htmlentities($_POST["input_Person_Vorname"])) : $vorname= "";
        isset($_POST["input_Person_Strasse"]) && is_string($_POST["input_Person_Strasse"]) ? $strasse = trim(htmlentities($_POST["input_Person_Strasse"])) : $strasse= "";
        isset($_POST["input_Person_PLZ"]) && is_string($_POST["input_Person_PLZ"]) ? $plz = trim(htmlentities($_POST["input_Person_PLZ"])) : $plz= "";
        isset($_POST["input_Person_Ort"]) && is_string($_POST["input_Person_Ort"]) ? $ort = trim(htmlentities($_POST["input_Person_Ort"])) : $ort= "";
        isset($_POST["input_Person_SVNr"]) && is_string($_POST["input_Person_SVNr"]) ? $svnr = trim(htmlentities($_POST["input_Person_SVNr"])) : $svnr= "";
        isset($_POST["input_Person_Email"]) && is_string($_POST["input_Person_Email"]) ? $email = trim(htmlentities($_POST["input_Person_Email"])) : $email= "";
        isset($_POST["input_Person_Passwort"]) && is_string($_POST["input_Person_Passwort"]) ? $pwd = trim(htmlentities($_POST["input_Person_Passwort"])) : $pwd= "";



        //------------------------------------------------------------------------------
        //Passwort peppern und hashen vor dem Eintrag in die Datenbank
        //MUSS NOCH GEMACHT WERDEN
        
        //Passwort peppern, sprich mit dem Pepper-String mischen für erhöhte Sicherheit. 
        //Pepper-String siehe config.php
        $pwd_peppered = hash_hmac ("sha256", $pwd, $pepper);

        //Passwort hashen -> dieser Passwort-Hash wird dann i.d. Datenbank eingetragen
        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);
        //------------------------------------------------------------------------------



        //auslesen der Checkbox!!!
        //$stammkunde = var_dump(isset($_POST["input_Person_Stammkunde"]));
        $stammkunde = isset($_POST["input_Person_Stammkunde"]) ? 1 : 0;


        isset($_POST["input_Person_Geschlecht"]) ? $geschlecht = $_POST["input_Person_Geschlecht"] : $geschlecht = "";
        isset($_POST["input_Person_Abonnement"]) ? $abo = $_POST["input_Person_Abonnement"] : $abo = "";




        try {

            //sql-Anweisung mit zu bindenden Parametern für das prepare-Statement
            //prepare-Statements sind wichtig, um SQL-Injection vorzubeugen
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


            $stmt = $conn->prepare($sql);

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
            $stmt->bindParam(':person_passwort', $pwd_hashed);
            
            $stmt->execute();
            //echo "Id des eingefügten Datensatzes: ".$conn->lastInsertId()."<br>";
            echo "<div class='alert alert-success' role='alert'>$vorname $nachname wurde erfolgreich gespeichert!</div>";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }
    ?>

    <h2 class="mt-5">Datenerfassung zur Person</h2>
    <form class="form-signin" onSubmit="return checkForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="person_register">       
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


        <div class="row">
            <div class="col-sm-6">
                <label for="input_Person_SVNr" class="sr-only">SVNr</label> 
                <input type="text" name="input_Person_SVNr" id="input_Person_SVNr" class="form-control" placeholder="SVNr" required autofocus oninput="setImgSrc()"> 
            </div>
            <div class="col-sm-6">
            <img id="svnrImg" src="images/valid.png" alt="valid" height="100">
            </div>
    </div>


        <label for="input_Person_Email" class="sr-only">Email-Adresse</label>
        <input type="email" name="input_Person_Email" id="input_Person_Email" class="form-control" placeholder="Email-Adresse" required>


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

        <label for="input_Person_Passwort" class="sr-only">Passwort</label>
        <input type="password" name="input_Person_Passwort" id="input_Person_Passwort" class="form-control" placeholder="Passwort" required>

      <input name="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit" id="submitBtn" value="Anmelden"></button>
    </form>
  </div> <!-- /container -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>