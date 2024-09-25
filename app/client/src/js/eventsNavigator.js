//EventsNavigator
const eventsNavigator = document.querySelector('[data-behaviour="eventsNavigator"]');

if(eventsNavigator != null){

    var choosenDate = null;
    var choosenEvent = null;
    var choosenTimeslot = null;
    var selectedGroupsize = 0;
    var availableSlots = 0;
    var usesCoupon = false;

    const eventStepCoupon = eventsNavigator.querySelector('[data-eventstep="coupon"]');
    const eventStep1 = eventsNavigator.querySelector('[data-eventstep="1"]');
    const eventStep2 = eventsNavigator.querySelector('[data-eventstep="2"]');
    const eventStep3 = eventsNavigator.querySelector('[data-eventstep="3"]');
    const eventStep4 = eventsNavigator.querySelector('[data-eventstep="4"]');
    const eventStep5 = eventsNavigator.querySelector('[data-eventstep="5"]');

    const couponButton = eventsNavigator.querySelector('[data-behaviour="coupon_button"]');
    const couponInput = eventsNavigator.querySelector('[data-behaviour="coupon_input"]');
    const couponMessage = eventsNavigator.querySelector('[data-behaviour="coupon_message"]');
    const couponDescription = eventsNavigator.querySelector('[data-behaviour="coupon_description"]');

    const dates = eventStep1.querySelectorAll('[data-behaviour="date"]');
    const events = eventStep2.querySelectorAll('[data-behaviour="event"]');
    const timeslots = eventStep3.querySelectorAll('[data-behaviour="timeslot"]');
    const coupontimeslots = eventStep3.querySelectorAll('[data-behaviour="coupontimeslot"]');
    const groupsizes = eventStep4.querySelectorAll('[data-behaviour="groupsize-button"]');

    const inputFieldEvent = eventStep5.querySelector('#Form_RegistrationForm_EventID');
    const inputFieldTimeslot = eventStep5.querySelector('#Form_RegistrationForm_TimeSlotID');
    const inputFieldGroupSize = eventStep5.querySelector('#Form_RegistrationForm_GroupSize');
    const inputFieldCouponcode = eventStep5.querySelector('#Form_RegistrationForm_Couponcode');

    if (eventStepCoupon) {
        //Fill Coupon field with coupon from address
        const currentadress = window.location.href;
        const url = new URL(currentadress);
        const coupon = url.searchParams.get('coupon');
        if (coupon) {
            couponInput.value = coupon;
            checkCoupon();
        }
        setupWithCoupon();
    } else {
        setupWithoutCoupon();
    }

    dates.forEach(date => {
        date.addEventListener('click', () => {
            eventStep2.classList.remove('hidden');
            eventStep3.classList.add('hidden');
            eventStep4.classList.add('hidden');
            eventStep5.classList.add('hidden');
            choosenEvent = null;

            const y2 = eventStep2.getBoundingClientRect().top + window.scrollY;
            setTimeout( () =>{
                window.scrollTo({
                    top: y2,
                    behavior: 'smooth'
                });
            }, 200);

            choosenDate = date;
            inputFieldEvent.value = '';
            inputFieldTimeslot.value = '';

            dates.forEach(dt => {
                dt.classList.remove('selected');
                if(dt === choosenDate){
                    dt.classList.add('selected');
                }
            });

            //Filter events for selected date
            events.forEach(event => {
                event.classList.remove('selected');
                if(event.getAttribute('data-date') == choosenDate.getAttribute('data-date')){
                    event.classList.remove('hidden');
                } else {
                    event.classList.add('hidden');
                }
            });
        });
    });

    events.forEach(event => {
        event.addEventListener('click', () => {
            eventStep3.classList.remove('hidden');
            eventStep4.classList.add('hidden');
            eventStep5.classList.add('hidden');

            choosenEvent = event;
            inputFieldEvent.value = choosenEvent.getAttribute('data-eventID');
            inputFieldTimeslot.value = '';

            const y3 = eventStep3.getBoundingClientRect().top + window.scrollY;
            setTimeout( () =>{
                window.scrollTo({
                    top: y3,
                    behavior: 'smooth'
                });
            }, 200);

            events.forEach(ev => {
                ev.classList.remove('selected');
                if(ev === choosenEvent){
                    ev.classList.add('selected');
                }
            });

            if (usesCoupon) {
                //Filter timeslots for selected event
                coupontimeslots.forEach(timeslot => {
                    timeslot.classList.remove('selected');
                    if (timeslot.getAttribute('data-eventID') == choosenEvent.getAttribute('data-eventID')) {
                        timeslot.classList.remove('hidden');
                    } else {
                        timeslot.classList.add('hidden');
                    }
                });
                timeslots.forEach(ts => {
                    ts.classList.add('hidden');
                });
            } else {
                //Filter timeslots for selected event
                timeslots.forEach(timeslot => {
                    timeslot.classList.remove('selected');
                    if (timeslot.getAttribute('data-eventID') == choosenEvent.getAttribute('data-eventID')) {
                        timeslot.classList.remove('hidden');
                    } else {
                        timeslot.classList.add('hidden');
                    }
                });
                coupontimeslots.forEach(ts => {
                    ts.classList.add('hidden');
                });
            }

            groupsizes.forEach(gs => {
                gs.classList.remove('selected');
                if(gs === selectedGroupsize){
                    gs.classList.add('selected');
                }
            });
        });
    });

    groupsizes.forEach(groupsize => {
        groupsize.addEventListener('click', () => {
            console.log('Groupsize: ' + groupsize.getAttribute('data-groupsize'));
            eventStep5.classList.remove('hidden');

            const y5 = eventStep5.getBoundingClientRect().top + window.scrollY * 1.5;
            setTimeout( () =>{
                window.scrollTo({
                    top: y5,
                    behavior: 'smooth'
                });
            }, 200);

            selectedGroupsize = groupsize.getAttribute('data-groupsize');
            inputFieldGroupSize.value = groupsize.getAttribute('data-groupsize');

            groupsizes.forEach(gs => {
                gs.classList.remove('selected');
                if(gs === groupsize){
                    gs.classList.add('selected');
                }
            });
        });
    });


    function setupWithoutCoupon() {
        eventStep1.classList.remove('hidden');
        eventStep2.classList.add('hidden');
        eventStep3.classList.add('hidden');
        eventStep4.classList.add('hidden');
        eventStep5.classList.add('hidden');
        console.log('Setup without coupon');
        setupTimeslots();
        coupontimeslots.forEach(ts => {
            ts.classList.add('hidden');
        });
    }


    function setupWithCoupon() {
        eventStep1.classList.add('hidden');
        eventStep2.classList.add('hidden');
        eventStep3.classList.add('hidden');
        eventStep4.classList.add('hidden');
        eventStep5.classList.add('hidden');
        console.log('Setup with coupon');
        couponButton.addEventListener('click', () => {
            checkCoupon();
        });
        couponInput.addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                checkCoupon();
            }
        });
        timeslots.forEach(ts => {
            ts.classList.add('hidden');
        });
        setupCouponTimeslots();
    }


    function checkCoupon() {
        console.log('Check coupon');
        //Check if coupon is valid with ajax
        //If valid, show eventStep1
        //If invalid, show event

        if (couponInput.value == '') {
            couponMessage.innerHTML = "Bitte geben Sie einen Coupon ein!";
            return;
        }

        eventStepCoupon.classList.add('loading');

        //fetch request to check coupon (with current domain + checkCoupon)
        const currentadress = window.location.href;
        const url = new URL(currentadress);
        const path = url.pathname;
        const checkCouponPath = path + '/checkCoupon' + "/" + couponInput.value;

        fetch(checkCouponPath, {
            method: 'POST',
            body: JSON.stringify({
                coupon: eventStepCoupon.querySelector('input').value
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            eventStepCoupon.classList.remove('loading');

            if (data.Valid) {
                eventStep1.classList.remove('hidden');
                couponMessage.innerHTML = "Coupon (" + data.Title + ") ist gültig!";
                usesCoupon = true;
                inputFieldCouponcode.value = couponInput.value;
                couponMessage.classList.add('valid');
                couponMessage.classList.remove('invalid');
                couponDescription.innerHTML = data.Description;
            } else {
                eventStepCoupon.classList.add('invalid');
                couponMessage.innerHTML = data.Message;
                usesCoupon = false;
                couponMessage.classList.add('invalid');
                couponMessage.classList.remove('valid');
                couponDescription.innerHTML = '';
                setupWithCoupon();
            }
        });
    }

    function setupTimeslots(){
        timeslots.forEach(timeslot => {
            timeslot.addEventListener('click', () => {
                eventStep4.classList.remove('hidden');
                eventStep5.classList.add('hidden');

                choosenTimeslot = timeslot;
                availableSlots = parseInt(choosenTimeslot.getAttribute('data-slotsize'));
                inputFieldTimeslot.value = choosenTimeslot.getAttribute('data-slotId');
                inputFieldGroupSize.max = availableSlots;

                const y4 = eventStep4.getBoundingClientRect().top + window.scrollY;
                setTimeout( () =>{
                    window.scrollTo({
                        top: y4,
                        behavior: 'smooth'
                    });
                }, 200);


                timeslots.forEach(ts => {
                    ts.classList.remove('selected');
                    if(ts === choosenTimeslot){
                        ts.classList.add('selected');
                    }
                });

                groupsizes.forEach(gs => {
                    gs.classList.remove('hidden');
                    gs.classList.remove('selected');
                    if(parseInt(gs.getAttribute('data-groupsize')) > availableSlots){
                        gs.classList.add('hidden');
                    }
                });
            });
        });
    }

    function setupCouponTimeslots(){
        coupontimeslots.forEach(timeslot => {
            timeslot.addEventListener('click', () => {
                eventStep4.classList.remove('hidden');
                eventStep5.classList.add('hidden');

                choosenTimeslot = timeslot;
                availableSlots = parseInt(choosenTimeslot.getAttribute('data-slotsize'));
                inputFieldTimeslot.value = choosenTimeslot.getAttribute('data-slotId');
                inputFieldGroupSize.max = availableSlots;

                const y4 = eventStep4.getBoundingClientRect().top + window.scrollY;
                setTimeout( () =>{
                    window.scrollTo({
                        top: y4,
                        behavior: 'smooth'
                    });
                }, 200);


                coupontimeslots.forEach(ts => {
                    ts.classList.remove('selected');
                    if(ts === choosenTimeslot){
                        ts.classList.add('selected');
                    }
                });

                groupsizes.forEach(gs => {
                    gs.classList.remove('hidden');
                    gs.classList.remove('selected');
                    if(parseInt(gs.getAttribute('data-groupsize')) > availableSlots){
                        gs.classList.add('hidden');
                    }
                });
            });
        });
    }
}
