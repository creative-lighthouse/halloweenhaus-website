import QrScanner from 'qr-scanner';
const qrVideo = document.getElementById('qrcode-video');

var popup = null;
var loading = null;

var decreaseSQButton = null;
var increaseSQButton = null;
var enterShowButton = null;

var amount_sq = 0;
var amount_vq = 0;
var amount_tt = 0;

var numbersVQ = null;
var numbersSQ = null;
var numbersTT = null;

var client_message = null;
var client_name = null;
var client_timeslot = null;
var client_timedifference = null;
var client_event = null;

var button_acceptTicket = null;
var button_declineTicket = null;

if(qrVideo) {
    popup = document.querySelector('.section_popup');
    loading = document.querySelector('.section_loading');

    decreaseSQButton = document.querySelector('.button_decreaseSQ');
    increaseSQButton = document.querySelector('.button_increaseSQ');
    enterShowButton = document.querySelector('.button_enterShow');

    numbersVQ = document.querySelector('.numbers_vq');
    numbersSQ = document.querySelector('.numbers_sq');
    numbersTT = document.querySelector('.numbers_tt');

    client_message = document.querySelector('.section_popup_client_message');
    client_name = document.querySelector('.section_popup_client_name');
    client_timeslot = document.querySelector('.section_popup_client_timeslot');
    client_timedifference = document.querySelector('.section_popup_client_timedifference');
    client_event = document.querySelector('.section_popup_client_event');

    button_acceptTicket = document.querySelector('.button_acceptTicket');
    button_declineTicket = document.querySelector('.button_deleteTicket');

    console.log('QR Scanner is ready to use');
    // To enforce the use of the new api with detailed scan results, call the constructor with an options object, see below.
    const qrScanner = new QrScanner(
        qrVideo,
        result => {
            const decodedUrl = new URL(result);
            console.log('Decoded URL:', decodedUrl);

            if(decodedUrl.hostname === "localhost" || decodedUrl.hostname === 'halloweenhaus-schmalenbeck.de') {
                //Get last part of the URL
                const urlParts = decodedUrl.pathname.split('/');
                const lastPart = urlParts[urlParts.length - 1];
                checkCode(lastPart);
            } else {
                console.log('URL is not from this domain');
            }
        }
    );
    qrScanner.start();

    decreaseSQButton.onclick = function () {
        decreaseSQ();
    }

    increaseSQButton.onclick = function () {
        increaseSQ();
    }

    enterShowButton.onclick = function () {
        enterShow();
    }
}

function checkCode($hash) {
    console.log('Checking code:', $hash);
    loading.style.display = 'flex';

    fetch('/checkCode/' + $hash, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            hash: $hash
        }),
    })
    .then(response => response.json())
    .then(data => {
        loading.style.display = 'none';
        popup.style.display = 'block';
        if (data.Valid) {
            client_message.innerHTML = data.message;
            client_name.innerHTML = data.Name;
            client_event.innerHTML = data.Event;
            client_timeslot.innerHTML = data.TimeSlot;

            //update time difference each second
            setInterval(function() {
                client_timedifference.innerHTML = calculateTimeDifference(data.Time);
            }, 1000);

            numbersVQ.innerHTML = data.VQ;
            numbersSQ.innerHTML = data.SQ;
            numbersTT.innerHTML = data.TT;

            button_acceptTicket.onclick = function() {
                acceptTicket($hash);
                popup.style.display = 'none';
            };

            button_declineTicket.onclick = function() {
                declineTicket($hash);
                popup.style.display = 'none';
            };
        }
    })
    .catch((error) => {
        popup.style.display = 'none';
    });
}

function calculateTimeDifference($time) {
    const time = new Date($time);
    const currentTime = new Date();
    const difference = time - currentTime;

    const minutes = Math.floor(difference / 60000);
    const seconds = Math.floor((difference % 60000) / 1000);

    if(difference > 0) {
        return '+' + minutes + ':' + seconds;
    } else {
        return '-' + minutes + ':' + seconds;
    }
}

function acceptTicket($hash) {
    fetch('/acceptTicket/' + $hash, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            hash: $hash
        }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.Valid) {
            popup.style.display = 'none';
        }
    })
    .catch((error) => {
        popup.style.display = 'none';
    });
}

function increaseSQ() {
    amount_sq++;
    numbersSQ.innerHTML = amount_sq;
}

function decreaseSQ() {
    if(amount_sq > 0) {
        amount_sq--;
        numbersSQ.innerHTML = amount_sq;
    }
}

function enterShow() {
    fetch('/enterShow', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            sq: amount_sq,
            vq: amount_vq,
            tt: amount_tt
        }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.Valid) {
            amount_sq = 0;
            numbersSQ.innerHTML = amount_sq;
        }
    })
    .catch((error) => {
        popup.style.display = 'none';
    });
}
