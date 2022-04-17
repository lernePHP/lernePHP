function setUserName() {
    //nameInfoUser.innerText = userName.value;
    console.log("in setUserName userName.value: " + userName.value);
    leftSymbol.innerHTML = userName.value;
    globUserName = userName.value;
}

let nrOfRoundsToPlay = 0;
let playedRounds = 0;

let userSymbol = "";
let userSymbolNr = 1;

let pcSymbol ="";
let pcSymbolNr = 1;

let userCounter = 0;
let pcCounter = 0;
counterUser.innerHTML = userCounter;
counterPc.innerHTML = pcCounter;

function startGame(symbol) {
    console.log("startGame");
    if (winCondition.value >=1) {
        lockBlock1.style.display = "block";
        lockBlock2.style.display = "block";

        nrOfRoundsToPlay = winCondition.value;

        rightSymbolBlink = false;
        document.getElementById("rightSymbol").style.opacity = 1;

        leftSymbolBlink = false;
        document.getElementById("leftSymbol").style.opacity = 1;

        userSymbol = symbol;
        userSymbolNr = getSymbolNr(userSymbol);
        document.getElementById("leftSymbol").style.backgroundImage = "url(img/" + getImageName(userSymbolNr, 'left')+ ")";

        pcSymbol = getSymbolOutOfRandom(getRandomInt(1,3));
        pcSymbolNr = getSymbolNr(pcSymbol);
        document.getElementById("rightSymbol").style.backgroundImage = "url(img/" + getImageName(pcSymbolNr, 'right')+ ")";

        calculateResult();
        playedRounds++;
    } else {
        alert("Die Anzahl der Runden muss >0 sein.");
    }
}


function getSymbolOutOfRandom(randomNr) {
    switch (randomNr) {
        case 1: return "Schere";
        case 2: return "Stein";
        case 3: return "Papier";
        default: return "Schere";
    }
}

function getSymbolNr(symbol) {
    switch(symbol) {
        case "Schere": return 1;
        case "Stein": return 2;
        case "Papier": return 3;
    }
}
function getSymbol(symbolNr) {
    switch(symbolNr) {
        case 1: return "Schere";
        case 2: return "Stein";
        case 3: return "Papier";
    }
}
function getImageName(symbolNr, place) {
    //place: left | right für Symbol auf der linken oder auf der rechten Seite
    if (place == "left") {
        switch(symbolNr) {
            case 1: return "scissorLeft.jpg";
            case 2: return "stoneLeft.jpg";
            case 3: return "paperLeft.jpg";
        }
    } else {
        switch(symbolNr) {
            case 1: return "scissor.jpg";
            case 2: return "stone.jpg";
            case 3: return "paper.jpg";
        } 
    }
}

function calculateResult() {
    //Du hast diese Runde verloren
    //Gratulation, Du hast gewonnen
    //Sorry, Du hast diese Runde verloren!
    //Gleichstand!

    //aktualisiert pcCounter und userCounter, je nach Ergebnis, in globalen Variablen und
    //im HTML (userCounter und pcCounter)
    
    switch(userSymbolNr) {
        case 1:
            //user wählte Schere
            switch(pcSymbolNr) {
                case 1:
                    //pc Wählte Schere
                    letWinnerBlink(true,true);
                    break;
                case 2:
                    //pc Wählte Stein
                    pcCounter++;
                    counterPc.innerHTML = pcCounter;
                    letWinnerBlink(false, true);
                    break;
                case 3: 
                    //pc Wählte Papier
                    userCounter++;
                    counterUser.innerHTML = userCounter;
                    letWinnerBlink(true, false);
                    break;
            }
            break;
        case 2:
            //user wählte Stein
            switch(pcSymbolNr) {
                case 1:
                    //pc Wählte Schere
                    userCounter++;
                    counterUser.innerHTML = userCounter;
                    letWinnerBlink(true, false);
                    break;
                case 2:
                    //pc Wählte Stein
                    letWinnerBlink(true, true);
                    break;
                case 3: 
                    //pc Wählte Papier
                    pcCounter++;
                    counterPc.innerHTML = pcCounter;
                    letWinnerBlink(false, true);
                    break;
            }
            break;
        case 3:
            //user wählte Papier
            switch(pcSymbolNr) {
                case 1:
                    //pc Wählte Schere
                    pcCounter++;
                    counterPc.innerHTML = pcCounter;
                    letWinnerBlink(false, true);
                    break;
                case 2:
                    //pc Wählte Stein
                    userCounter++
                    counterUser.innerHTML = userCounter;
                    letWinnerBlink(true, false);
                    break;
                case 3: 
                    //pc Wählte Papier
                    letWinnerBlink(true, true);
                    break;
            }
            break;
    }
}
function finishGame() {
    if (playedRounds == nrOfRoundsToPlay) {
        showEndresult();
    }
}

function showEndresult() {

    if (userCounter == pcCounter) {
        createPopup("Unentschieden (" + userCounter + " : " + pcCounter + ")", true);
    } else if (userCounter > pcCounter) {
        createPopup("Du hast mit " + userCounter + " : " + pcCounter + " gewonnen! Herzlichen Glückwunsch!", true);
    } else {
        createPopup("Sorry! Du hast mit " + userCounter + " : " + pcCounter + " leider verloren", true);
    }
}

function reset() {
    lockBlock1.style.display = "none"; 
    nrOfRoundsToPlay = 0;
    playedRounds = 0;

    userSymbol = "";
    userSymbolNr = 1;

    pcSymbol ="";
    pcSymbolNr = 1;

    userCounter = 0;
    pcCounter = 0;
    counterUser.innerHTML = userCounter;
    counterPc.innerHTML = pcCounter;

    //leftSymbol.innerHTML = "Du";
    document.getElementById("leftSymbol").style.backgroundImage = "";
    document.getElementById("rightSymbol").style.backgroundImage = "";
}

let countBlink = 0;
let countWinnerBlink = 1;
setInterval(blink, 500); 
let leftSymbolBlink = false;
let rightSymbolBlink = false;
function blink() {
    
    if (leftSymbolBlink == true) {
        id = "leftSymbol";

        if (countWinnerBlink <= 6) {
            if (((countBlink*10) % 10) != 0) {
                document.getElementById(id).style.opacity = 0.2;
            } else {
                document.getElementById(id).style.opacity = 1;
            }           
        } else {
            leftSymbolBlink = false;
            document.getElementById(id).style.opacity = 1;

            lockBlock2.style.display = "none";
            finishGame();
        }
    }
    if (rightSymbolBlink == true) {
        id = "rightSymbol";

        if (countWinnerBlink <= 6) {
            if (((countBlink*10) % 10) != 0) {
                document.getElementById(id).style.opacity = 0.2;
            } else {
                document.getElementById(id).style.opacity = 1;
            }           
        } else {
            rightSymbolBlink = false;
            document.getElementById(id).style.opacity = 1;
            lockBlock2.style.display = "none";
            finishGame();
        }
    }

    countWinnerBlink++;
    countBlink = countBlink + 0.5;

}
function letWinnerBlink(blinkLeft, blinkRight) {
    countWinnerBlink = 1;
    
    if (blinkLeft == true) {
        leftSymbolBlink = true;
    } else {
        leftSymbolBlink = false;
    }

    if (blinkRight == true) {
        rightSymbolBlink = true;
    } else {
        rightSymbolBlink = false;
    }
}

function createPopup(errorText, reload = false) {
    //reload: false ist default-Wert
    let popup = document.createElement('div');
    popup.setAttribute('id', 'popup');

    let headline = document.createElement('h3');
    headline.append(errorText);
    
    let button = document.createElement('button');
    if (reload) {
        button.append('Nochmal spielen');
        button.addEventListener('click', function() {
            console.log("popup click");
            reset();
            document.getElementById('popup').remove();
        })
    } else {
        button.append('ok');
        button.addEventListener('click', function() {
            document.getElementById('popup').remove();
        })
    }


    popup.append(headline);
    popup.append(button);
    document.body.append(popup);
}