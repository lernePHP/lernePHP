<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrays</title>
</head>
<body>
    <?php
        //-------------------------------------------------------
        //Möglichkeiten, um arrays zu erstellen:
        //------------------------------------------------------

        //Variante1
        $array1 = ["heute","morgen","übermorgen"];  

        //Variante2
        $array2 = array("Woche1", "Woche2", "Woche3");

        //Variante3
        $array3 = [];
        $array3[0] = "Pizza";
        $array3[1] = "Pasta";
        $array3[2] = "Salat";

        $array4 = array("Nachname"  => "Hauser",
                        "Vorname"   => "Hannes",
                        "Email"     => "hannes.hauser@gmail.com");
        //-------------------------------------------------------




        //------------------------------------------------------
        //Array durchwandern und Key / Values ausgeben
        //------------------------------------------------------
        //mit dieser Variante werden nur die Werte ausgegeben
        foreach ($array1 as $value) {
            echo "$value <br>";
        }

        //mit dieser Variante hat man Zugriff auf den key UND den value
        foreach ($array3 as $key => $value) {
            echo "key: $key, value: $value <br>";
        }

        foreach($array4 as $key => $value){
            echo "key: $key, value: $value <br>";
        }

        //assoziative Arrays kann man direkt über den sprechenden key ansprechen
        //so macht man das mit Query-Results. Das sind assoziative arrays, wobei die Keys die Feldnamen sind und die Values die Feldinhalte
        echo $array4['Nachname']." <br>";
        echo $array4['Vorname']." <br>";
        echo $array4['Email']." <br>";
        //---------------------------------------------------------



        //------------------------------------------------------
        //Anzahl der Elemente ausgeben
        //------------------------------------------------------
        echo "Anzahl Elemente: ".count($array1);
        //------------------------------------------------------


        //zum komplexeren durchwandern mit der Möglichkeit, wieder auf ein zurückzuspringen ... kann man einen Iterator bauen
        //das machen wir hier aber nicht.
    ?>
</body>
</html>