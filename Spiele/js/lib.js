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
                location.reload();
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

function getRandomInt(min=1, max) {
    //gibt eine Zufalls-Ganzzahl zurück. Min und Max sind im Wertebereich enthalten.
    return Math.floor(Math.random() * (max - min + 1)) + min;
}