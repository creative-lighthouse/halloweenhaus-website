//EventsNavigator
const eventsNavigator = document.querySelector('[data-behaviour="eventsNavigator"]');

if(eventsNavigator != null){

    var choosenDate = null;
    var choosenEvent = null;
    var choosenTimeslot = null;
    var selectedGroupsize = 0;
    var availableSlots = 0;

    const eventStep1 = eventsNavigator.querySelector('[data-eventstep="1"]');
    const eventStep2 = eventsNavigator.querySelector('[data-eventstep="2"]');
    const eventStep3 = eventsNavigator.querySelector('[data-eventstep="3"]');
    const eventStep4 = eventsNavigator.querySelector('[data-eventstep="4"]');
    const eventStep5 = eventsNavigator.querySelector('[data-eventstep="5"]');

    eventStep1.classList.remove('hidden');

    const dates = eventStep1.querySelectorAll('[data-behaviour="date"]');
    const events = eventStep2.querySelectorAll('[data-behaviour="event"]');
    const timeslots = eventStep3.querySelectorAll('[data-behaviour="timeslot"]');
    const groupsizes = eventStep4.querySelectorAll('[data-behaviour="groupsize-button"]');

    const inputFieldEvent = eventStep5.querySelector('#Form_RegistrationForm_EventID');
    const inputFieldTimeslot = eventStep5.querySelector('#Form_RegistrationForm_TimeSlotID');
    const inputFieldGroupSize = eventStep5.querySelector('#Form_RegistrationForm_GroupSize');

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

            //Filter timeslots for selected event
            timeslots.forEach(timeslot => {
                timeslot.classList.remove('selected');
                if(timeslot.getAttribute('data-eventID') == choosenEvent.getAttribute('data-eventID')){
                    timeslot.classList.remove('hidden');
                } else {
                    timeslot.classList.add('hidden');
                }
            });

            groupsizes.forEach(gs => {
                gs.classList.remove('selected');
                if(gs === selectedGroupsize){
                    gs.classList.add('selected');
                }
            });
        });
    });

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
}
