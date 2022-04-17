<?php
require_once 'config.php';
require_once 'connection.php';

$email = "";
$pwd = "";

//CHECKING SUBMIT BUTTON PRESS or NOT.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitBtn"]) && $_POST["submitBtn"]!="" && !empty($_POST["submitBtn"])) { 

    isset($_POST["input_Person_Email"]) && is_string($_POST["input_Person_Email"]) ? $email = trim($_POST["input_Person_Email"]) : $email= "";
    isset($_POST["input_Person_Passwort"]) && is_string($_POST["input_Person_Passwort"]) ? $pwd = trim($_POST["input_Person_Passwort"]) : $pwd= "";



    //------------------------------------------------------------------------------
    //Passwort peppern und hashen vor dem Eintrag in die Datenbank
    //MUSS NOCH GEMACHT WERDEN
    
    //eingegebenes Passwort peppern, sprich mit dem Pepper-String mischen für erhöhte Sicherheit. 
    //Pepper-String siehe config.php
    $pwd_peppered = hash_hmac ("sha256", $pwd, $pepper);
    //------------------------------------------------------------------------------



//SELECT `Person_Email`, `Person_Passwort` FROM `person` WHERE `Person_Email` = 'markus@gmail.com'
    try {
        
        $stmt = $conn->prepare("SELECT `Person_Email`, `Person_Passwort` FROM `person` WHERE `Person_Email` = :email");
        $stmt->bindParam(':email', $email);
      
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pwd_hashed = "";  //initialisieren, falls es die Email-Adresse nicht gibt

        //Abfrageergebnis auslesen
        foreach($result as $row => $akt_person) {
            $pwd_hashed = $akt_person['Person_Passwort'];
        }

        if ($pwd_hashed == "") {
            echo "user nicht vorhanden.";
        } 
        else {
            if (password_verify($pwd_peppered, $pwd_hashed)) {
                echo "Password matches";
            }
            else {
                echo "Password incorrect";
            }    
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
        <label for="input_Person_Email" class="sr-only">Email-Adresse</label>
        <input type="email" name="input_Person_Email" id="input_Person_Email" class="form-control" placeholder="Email-Adresse" required>

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