/**
 * Created by Simon on 18/02/2016.
 * updated on 19/05/2016
 */

function play(idPlayer, control) {
    var player = document.querySelector('#' + idPlayer);

    if(player.paused) {
        player.play();
        control.innerHTML = '<i class="fa fa-pause"></i>';
    }
    else {
        player.pause();
        control.innerHTML = '<i class="fa fa-play"></i>';
    }
}

function stop(idPlayer) {
    var player = document.querySelector('#' + idPlayer);

    player.currentTime = 0;
    player.pause();
}

function volume(idPlayer, vol) {
    var player = document.querySelector('#' + idPlayer);

    player.volume = parseInt(vol) / 100;
}

function update(player, idProgress) {
    var duration = player.duration; //Durée totale
    var time = player.currentTime; //Temps écoulé
    var fraction = time / duration;
    var percent = Math.ceil(fraction * 100);

    var progress = document.querySelector('#' + idProgress);

    progress.style.width = percent + '%';
    progress.textContent = percent + '% / ' + formatTime(time);
}

function formatTime(time) {
    var hours = Math.floor(time / 3600);
    var mins = Math.floor((time % 3600) / 60);
    var secs = Math.floor(time % 60);

    if (secs < 10) {
        secs = "0" + secs;
    }

    if (hours) {
        if (mins < 10) {
            mins = "0" + mins;
        }

        return hours + ":" + mins + ":" + secs;
    }
    else {
        return mins + ":" + secs;
    }
}

function getMousePosition(event) {
    return {
        x: event.pageX,
        y: event.pageY
    };
}

function getPosition(element){
    var top = 0, left = 0;

    do {
        top  += element.offsetTop;
        left += element.offsetLeft;
    } while (element = element.offsetParent);

    return { x: left, y: top };
}

function clickProgress(idPlayer, control, event, idProgress) {
    var parent = getPosition(control);    // La position absolue de la progressBar
    var target = getMousePosition(event); // L'endroit de la progressBar où on a cliqué
    var player = document.querySelector('#' + idPlayer);

    var x = target.x - parent.x;
    var wrapperWidth = document.querySelector('#' + idProgress).offsetWidth;

    var percent = Math.ceil((x / wrapperWidth) * 100);
    var duration = player.duration;

    player.currentTime = (duration * percent) / 100;
}