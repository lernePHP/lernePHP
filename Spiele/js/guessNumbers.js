let upperLimit;
let nrOfTries;
let randomNumber;

function startGame() {
    console.log("Hallo");
    lock.style.display = "block";

    upperLimit = upperLimitInput.value;
    console.log("upperlimit: " + upperLimit);

    nrOfTries = nrOfTriesInput.value;

    nrOfTriesLeft.innerHTML = nrOfTries;
    console.log("nrOfTries: " + nrOfTries);

    randomNumber = getRandomInt(1,upperLimit);
    console.log("randomNumber: " + randomNumber);

    gameContainerPlus.style.display = "flex";
}

function guess() {
    let guessNumber =guessNumberInput.value;


    if (randomNumber == guessNumber) {
        createPopup("Gratulation!", true);
    } else if (guessNumber < randomNumber) {
        appendToSide(guessNumber, "left");

        if (nrOfTries == 1) {
            createPopup("Zu klein! Du hast leider keine Versuche mehr frei.", true);
            setTimeout(function(){ 
                lock.style.display = "none";
                gameContainerPlus.style.display = "none";
            }, 1000);
        } else {
            createPopup("zu klein", false);
            nrOfTries--;
            nrOfTriesLeft.innerHTML = nrOfTries;
        }


    } else {
        appendToSide(guessNumber, "right");

        if (nrOfTries == 1) {
            //alert("Du hast leider keine Versuche mehr!");
            createPopup("Zu groß! Du hast leider keine Versuche mehr frei.", true);
            setTimeout(function(){ 
                lock.style.display = "none";
                gameContainerPlus.style.display = "none";
            }, 1000);
        } else {
            createPopup("zu groß", false);
            nrOfTries--;
            nrOfTriesLeft.innerHTML = nrOfTries;
        }
    }
}

function appendToSide(number, side) {
    let newDiv = document.createElement('div');

    newDiv.classList.add("guessedNumber");
    newDiv.append(number);

    console.log("side: " + side);
    if (side == "left") {
        leftSide.append(newDiv);
    } else {
        rightSide.append(newDiv);
    }
}


