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
    <h2 class="mt-5">Bootstrap Formular-Vorlage</h2>
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h4 class="form-signin-heading mt-5">anmelden</h4>
        
        <label for="eingabefeldNachname" class="sr-only">Nachname</label>
        <input type="text" name="eingabefeldNachname" id="eingabefeldNachname" class="form-control" placeholder="Nachname" required autofocus>

        <label for="eingabefeldVorname" class="sr-only">Vorname</label>
        <input type="text" name="eingabefeldVorname" id="eingabefeldVorname" class="form-control" placeholder="Vorname" required>

        <label for="eingabefeldEmail" class="sr-only">Email-Adresse</label>
        <input type="email" name="eingabefeldEmail" id="eingabefeldEmail" class="form-control" placeholder="Email-Adresse" required>

        <label for="eingabefeldPasswort" class="sr-only">Passwort</label>
        <input type="password" id="eingabefeldPasswort" class="form-control" placeholder="Passwort" required>
        
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Anmeldung speichern
            </label>
        </div>

        <label for="exampleFormControlTextarea1" class="sr-only">Example textarea</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="exampleText"></textarea>


        <h4 class="form-signin-heading mt-5">oder so:</h4>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>

      <input name="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit" id="submitBtn" value="Anmelden"></button>
    </form>
  </div> <!-- /container -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>