//EventsNavigator
const eventsNavigator = document.querySelector('[data-behaviour="eventsNavigator"]');

if(eventsNavigator != null){

    var choosenDate = null;
    var choosenEvent = null;
    var choosenTimeslot = null;

    const eventStep1 = eventsNavigator.querySelector('[data-eventstep="1"]');
    const eventStep2 = eventsNavigator.querySelector('[data-eventstep="2"]');
    const eventStep3 = eventsNavigator.querySelector('[data-eventstep="3"]');
    const eventStep4 = eventsNavigator.querySelector('[data-eventstep="4"]');

    eventStep1.classList.remove('hidden');

    const dates = eventStep1.querySelectorAll('[data-behaviour="date"]');
    const events = eventStep2.querySelectorAll('[data-behaviour="event"]');
    const timeslots = eventStep3.querySelectorAll('[data-behaviour="timeslot"]');

    const inputFieldEvent = eventStep4.querySelector('#Form_RegistrationForm_EventID');
    const inputFieldTimeslot = eventStep4.querySelector('#Form_RegistrationForm_TimeSlotID');

    dates.forEach(date => {
        date.addEventListener('click', () => {
            eventStep2.classList.remove('hidden');
            eventStep3.classList.add('hidden');
            eventStep4.classList.add('hidden');
            choosenEvent = null;

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

            choosenEvent = event;
            inputFieldEvent.value = choosenEvent.getAttribute('data-eventID');
            inputFieldTimeslot.value = '';

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
        });
    });

    timeslots.forEach(timeslot => {
        timeslot.addEventListener('click', () => {
            eventStep4.classList.remove('hidden');
            choosenTimeslot = timeslot;
            timeslots.forEach(ts => {
                ts.classList.remove('selected');
                if(ts === choosenTimeslot){
                    ts.classList.add('selected');
                }
            });
        });
    });
}
