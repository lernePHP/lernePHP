let code=[];
let guessedCode=[];
let nrOfTries;

code[0] = getRandomInt(1,9);
code[1] = getRandomInt(1,9);
code[2] = getRandomInt(1,9);
console.log("code: " + code);
/*
for (let i=0; i < code.length; i++) {
    console.log(code[i]);
}
*/

function startGame() {
    console.log("Hallo");
    lock.style.display = "block";

    nrOfTries = nrOfTriesInput.value;

    nrOfTriesLeft.innerHTML = nrOfTries;
    console.log("nrOfTries: " + nrOfTries);

    gameContainerPlus.style.display = "flex";
}

function guess() {
    console.log("in guess");

    guessedCode[0] = number1.value;
    guessedCode[1] = number2.value;
    guessedCode[2] = number3.value;
    console.log("guessedCode: " + guessedCode);
}