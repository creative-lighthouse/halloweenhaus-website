<head>
    <% base_tag %>
    $MetaTags(false)
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <title>$Title - $SiteConfig.Title</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../mask_icon.svg" color="#ffffff">

    <meta property="og:title" content="$Title - $SiteConfig.Title" />
    <meta property="og:site_name" content="$Title" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="$Description">
    <meta property="og:url" content="$Link" />
    <% if $Image %>
    <meta property="og:image" content="$Image.Link" />
    <% else %>
    <meta property="og:image" content="../_resources/app/client/images/socialmedia.png" />
    <meta property="og:image:alt" content="Otto Woodmann vor einem dunklem Wald" />
    <% end_if %>
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:locale" content="de_DE" />
    <meta name="twitter:card" content="summary_large_image">

    <meta name="msapplication-TileColor" content="#151515">
    <meta name="theme-color" content="#151515">
    <link rel="stylesheet" href="$Mix("/css/styles.min.css")">
</head>
<body class="ticket">
    <% if $CurrentUser %>
        <div class="section section--EventsAdmin">
            <div class="section_content">
                <div class="section_qrcodescan">
                    <video id="qrcode-video"></video>
                    <div class="scan-region-highlight" style="position: absolute; pointer-events: none; transform: scaleX(-1);">
                        <svg class="scan-region-highlight-svg" viewBox="0 0 238 238" preserveAspectRatio="none" style="position:absolute;width:100%;left:0;top:0;fill:none;stroke:#e9b213;stroke-width:4;stroke-linecap:round;stroke-linejoin:round"><path d="M31 2H10a8 8 0 0 0-8 8v21M207 2h21a8 8 0 0 1 8 8v21m0 176v21a8 8 0 0 1-8 8h-21m-176 0H10a8 8 0 0 1-8-8v-21"></path></svg><svg class="code-outline-highlight" preserveAspectRatio="none" style="display:none;width:100%;fill:none;stroke:#e9b213;stroke-width:5;stroke-dasharray:25;stroke-linecap:round;stroke-linejoin:round"><polygon></polygon></svg>
                    </div>
                    <div class="section_bottombar">
                        <div class="clock">
                            <p class="clock_text">00:00</p>
                        </div>
                        <div class="logo">
                            <% include MovingLogo %>
                        </div>
                    </div>
                </div>
                <div class="section_counter">
                    <a class="section_counter_button button_increaseSQ">
                        <img class="button_icon" src="../_resources/app/client/icons/event_admin/icon_increase.svg"/>
                    </a>
                    <a class="section_counter_button button_decreaseSQ">
                        <img class="button_icon" src="../_resources/app/client/icons/event_admin/icon_decrease.svg"/>
                    </a>
                    <a class="section_counter_button button_enterShow">
                        <img class="button_icon" src="../_resources/app/client/icons/event_admin/icon_enter.svg"/>
                    </a>
                </div>
                <div class="section_numbers">
                    <div class="section_numbers_entry">
                        <img class="numbers_icon" src="../_resources/app/client/icons/event_admin/icon_virtualqueue.svg"/>
                        <p class="numbers_vq">0</p>
                    </div>
                    <div class="section_numbers_entry">
                        <img class="numbers_icon" src="../_resources/app/client/icons/event_admin/icon_standbyqueue.svg"/>
                        <p class="numbers_sq">0</p>
                    </div>
                    <div class="section_numbers_entry">
                        <img class="numbers_icon" src="../_resources/app/client/icons/event_admin/icon_queuetotal.svg"/>
                        <p class="numbers_tt">0</p>
                    </div>
                </div>
                <div class="section_popup">
                    <a class="section_popup_text section_popup_close">X</a>
                    <p class="section_popup_text section_popup_client_message"></p>
                    <p class="section_popup_text section_popup_client_name"></p>
                    <hr>
                    <p class="section_popup_text section_popup_client_event"></p>
                    <p class="section_popup_text section_popup_client_timeslot"></p>
                    <hr>
                    <p class="section_popup_text section_popup_client_timedifference"></p>
                    <div class="section_popup_buttons">
                        <a class="section_popup_button button_deleteTicket">Löschen</a>
                        <a class="section_popup_button button_checkinGuest">Einlass</a>
                    </div>
                </div>
                <div class="section_loading">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    <% end_if %>



    <!--Admin Scanner Script-->
    <script type="module">
        import QrScanner from '../_resources/app/client/dist/qr-scanner.min.js';

        const qrVideo = document.getElementById('qrcode-video');
        const popup = document.querySelector('.section_popup');
        const loading = document.querySelector('.section_loading');
        const decreaseSQButton = document.querySelector('.button_decreaseSQ');
        const increaseSQButton = document.querySelector('.button_increaseSQ');
        const enterShowButton = document.querySelector('.button_enterShow');
        const numbersVQ = document.querySelector('.numbers_vq');
        const numbersSQ = document.querySelector('.numbers_sq');
        const numbersTT = document.querySelector('.numbers_tt');
        const client_message = document.querySelector('.section_popup_client_message');
        const client_name = document.querySelector('.section_popup_client_name');
        const client_timeslot = document.querySelector('.section_popup_client_timeslot');
        const client_timedifference = document.querySelector('.section_popup_client_timedifference');
        const client_event = document.querySelector('.section_popup_client_event');
        const button_checkinGuest = document.querySelector('.button_checkinGuest');
        const button_declineTicket = document.querySelector('.button_deleteTicket');
        const button_closePopup = document.querySelector('.section_popup_close');
        const popup_buttons = document.querySelector('.section_popup_buttons');
        const clock_text = document.querySelector('.clock_text');

        let timeDifferenceInterval = null;

        var amount_sq = 0;
        var amount_vq = 0;
        var amount_tt = 0;

        var popup_active = false;

        setup();

        //Setup QR Scanner
        function setup() {
            const qrScanner = new QrScanner(
                qrVideo,
                result => {
                    //check if result is valid url

                    if(popup_active) {
                        return;
                    }

                    if(result === '') {
                        return;
                    }

                    if(result.includes('http') === false) {
                        return;
                    }

                    const decodedUrl = new URL(result);
                    console.log('Decoded URL:', decodedUrl);

                    if(popup_active) {
                        return;
                    }

                    //For testing
                    const urlParts = decodedUrl.pathname.split('/');
                    const lastPart = urlParts[urlParts.length - 1];
                    checkCode(lastPart);

                    if(decodedUrl.hostname == "localhost" || decodedUrl.hostname == 'halloweenhaus-schmalenbeck.de') {
                        //Get last part of the URL
                        const urlParts = decodedUrl.pathname.split('/');
                        const lastPart = urlParts[urlParts.length - 1];
                        checkCode(lastPart);
                    } else {
                        console.log('URL is not from this domain: ' + decodedUrl.hostname);
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

            button_closePopup.onclick = function() {
                closePopup();
            }



            //update clock every 10 Seconds
            setInterval(function() {
                updateClock();
            }, 1000);
        }

        //Check Code if it is valid
        function checkCode(hash) {
            console.log('Checking code:', hash);
            loading.style.display = 'flex';

            if(hash === '') {
                loading.style.display = 'none';
                return;
            }
            fetch('./api/checkCode/' + hash, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    hash: hash
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                loading.style.display = 'none';
                popup.style.display = 'block';
                popup_active = true;

                client_message.classList.remove('valid');
                client_message.classList.remove('problematic');
                client_message.classList.remove('invalid');

                if (data.Valid) {
                    popup_buttons.style.display = 'flex';

                    if(data.Status == "Confirmed"){
                        client_message.classList.add('valid');
                    } else {
                        client_message.classList.add('problematic');
                    }

                    client_message.innerHTML = data.Message;
                    if(data.GroupSize > 1) {
                        client_name.innerHTML = data.Name + " (" + data.GroupSize + " Personen)";
                    } else {
                        client_name.innerHTML = data.Name + " (" + data.GroupSize + " Person)";
                    }
                    client_event.innerHTML = data.Event;
                    client_timeslot.innerHTML = data.TimeSlot;

                    //update time difference each second
                    timeDifferenceInterval = setInterval(function() {
                        if(popup_active) {
                            client_timedifference.innerHTML = calculateTimeDifference(data.TimeSlot);
                        }
                    }, 1000);

                    button_checkinGuest.onclick = function() {
                        checkinGuest(data.EventID, hash);
                        closePopup();
                    };

                    button_declineTicket.onclick = function() {
                        declineTicket(data.eventid, hash);
                        closePopup();
                    };
                } else {
                    popup_buttons.style.display = 'none';
                    client_message.innerHTML = data.Message;
                    client_message.classList.add('invalid');
                }
            })
            .catch((error) => {
                closePopup();
            });
        }

        //Calculate time difference between current time and ticket time
        function calculateTimeDifference(time) {
            //Get current time
            const currentTime = new Date();

            //Get ticket time
            const [datePart, timePart] = time.split(' ');
            const [day, month, year] = datePart.split('.');
            const [tickethours, ticketminutes] = timePart.split(':');
            const ticketTime = new Date(year, month - 1, day, tickethours, ticketminutes);

            //Calculate difference and output in human readable format (X days, X hours, X seconds) and add - or + depending on the difference
            const difference = ticketTime - currentTime;
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            var returnedString = "";
            if(difference < 0) {
                returnedString += 'Abgelaufen seit: ';
            } else {
                returnedString += 'Gültig in: ';
            }

            if(days > 0) {
                if(days == 1) {
                    returnedString += days + ' Tag, ';
                } else {
                    returnedString += days + ' Tage, ';
                }
            }
            if(hours > 0) {
                if (hours == 1) {
                    returnedString += hours + ' Stunde, ';
                } else {
                    returnedString += hours + ' Stunden, ';
                }
            }
            if(minutes > 0) {
                if(minutes == 1) {
                    returnedString += minutes + ' Minute ';
                } else {
                    returnedString += minutes + ' Minuten ';
                }
            }
            if(seconds == 1) {
                returnedString += 'und ' + seconds + ' Sekunde.';
            } else {
                returnedString += 'und ' + seconds + ' Sekunden.';
            }

            return returnedString;
        }

        //Accept Ticket
        function checkinGuest(eventid, hash) {
            fetch('./api/checkin?event=' + eventid + '&hash=' + hash, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    hash: hash,
                    eventid: eventid
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.Valid) {
                    popup.style.display = 'none';
                    amount_vq += data.GroupSize;
                    updateNumbers();
                }
            })
            .catch((error) => {
                popup.style.display = 'none';
            });
        }

        //Increase Standby Queue Count
        function increaseSQ() {
            amount_sq++;
            updateNumbers();
        }

        //Decrease Standby Queue Count
        function decreaseSQ() {
            if(amount_sq > 0) {
                amount_sq--;
                updateNumbers();
            }
        }

        //Enter Show
        function enterShow() {
            fetch('./api/enterShow', {
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
                    amount_vq = 0;
                    updateNumbers();
                }
            })
            .catch((error) => {
                popup.style.display = 'none';
            });
        }

        function updateNumbers() {
            numbersVQ.innerHTML = amount_vq;
            numbersSQ.innerHTML = amount_sq;
            amount_tt = amount_vq + amount_sq;
            numbersTT.innerHTML = amount_tt;
        }

        function closePopup() {
            popup.style.display = 'none';
            popup_active = false;
            client_message.innerHTML = "";
            client_name.innerHTML = "";
            client_event.innerHTML = "";
            client_timeslot.innerHTML = "";
            client_timedifference.innerHTML = "";
            clearInterval(timeDifferenceInterval);
        }

        function updateClock() {
            const currentTime = new Date();
            const day = currentTime.getDate();
            const month = currentTime.getMonth() + 1;
            const hours = currentTime.getHours();
            const minutes = currentTime.getMinutes();

            var hoursString = hours;
            var minutesString = minutes;
            var dayString = day;
            var monthString = month;

            if(hours < 10) {
                hoursString = '0' + hours;
            }
            if(minutes < 10) {
                minutesString = '0' + minutes;
            }
            if(day < 10) {
                dayString = '0' + day;
            }
            if(month < 10) {
                monthString = '0' + month;
            }

            clock_text.innerHTML = dayString + "." + monthString + ". | " + hoursString + ':' + minutesString;
        }
    </script>
    <!--Admin Scanner Script End-->


    <script src="$Mix("/js/main.js")"></script>
</body>
