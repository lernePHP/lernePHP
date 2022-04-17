let fallingSpeed;
let planet;
let distanceToMonster = Math.random() * 90 + 10;
distanceToMonster = Math.round(distanceToMonster);
let counter = 1;

function startGame(planetInput, fallingSpeedInput) {
    if (nrOfTries.value <= 0) {
        alert("Die Anzahl der Versuche muss mindestens eins sein.");
    } else {
        triesLeft.innerHTML = nrOfTries.value;
        planet = planetInput;
        chosenPlanet.innerHTML = "Wir befinden uns auf dem Planeten " + planet + ".";
        fallingSpeed = fallingSpeedInput;
    
        distance.innerHTML = distanceToMonster;
    
        //document.getElementById("gameContainer").classList.remove("inactive");
        document.getElementById("gameContainer").style.display ="flex";
        document.getElementById("start").style.display = "none";

        //Background-Image
        backgroundImage.style.display = "block";

        if (planet == "Erde") {
            backgroundImage.style.backgroundImage = "url(img/earth.png)";
        } else if (planet == "Mond") {
            backgroundImage.style.backgroundImage = "url(img/moon.png)";
        } else if (planet == "Jupiter") {
            backgroundImage.style.backgroundImage = "url(img/jupiter.png)";
        } else if (planet == "Mars") {
            backgroundImage.style.backgroundImage = "url(img/mars.png)";
        }

        

    }
}

function throwMobile() {
    if ((nrOfTries.value >=1) && (counter <= nrOfTries.value)) {
        console.log("falling speed in throwMobile: " + fallingSpeed);
        if ((angleInput.value < 1) || (angleInput.value> 90)) {
            alert("Bitte geben Sie einen Winkel zwischen 1 und 90 an!");
        } else {
            let speed = speedInput.value;
            let angle = angleInput.value * ( Math.PI / 180 );
    
            console.log("Speed: " + speed);
            console.log("Winkel: " + angle);
        
            let throwingDistance = ((speed * speed) * Math.sin(2 * angle)) / fallingSpeed;
            console.log(throwingDistance);
            throwingDistance = Math.round(throwingDistance);
            console.log(throwingDistance);
    
            let difference = throwingDistance - distanceToMonster;
            if (throwingDistance == distanceToMonster) {
                console.log("Herzlichen Glückwunsch!!! Du hast das Monster getroffen.");
                resultTxt.innerHTML = "Herzlichen Glückwunsch!!! Du hast das Monster getroffen.";
            } else if (throwingDistance > distanceToMonster) {
                console.log("zu weit");
                resultTxt.innerHTML = "Du hast " + throwingDistance + " m geworfen. Das ist um " + difference + " m zu weit.";
            } else {
                console.log("zu wenig weit!");
                resultTxt.innerHTML = "Du hast " + throwingDistance + " m geworfen. Das ist um " + (difference * -1) + " m zu wenig weit.";
            }

            document.getElementById("resultTxt").classList.remove("inactive");
            triesLeft.innerHTML = nrOfTries.value - counter;
            counter++; 
        }
    } else {
        if (nrOfTries.value < 1) {
            resultTxt.innerHTML = "Anzahl der Versuche muss mindestens 1 sein!";
        } else {
            resultTxt.innerHTML = "Du hast keine Versuche mehr";
            alert("Du hast keine Versuche mehr!");
            location.href="longthrow.html";
        }
        
    }
    
}