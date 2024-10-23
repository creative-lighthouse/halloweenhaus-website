import Chart from 'chart.js/auto';
import 'chartjs-adapter-moment';

const statPage = document.querySelector('.statistics-page');
const stat_totalGuests = document.querySelector('[data-behaviour="stat_totalthisyear"]');
const stat_GuestsPerDayHolder = document.querySelector('[data-behaviour="stat_guestsperday"]');
const stat_GuestsPerHourHolder = document.querySelector('[data-behaviour="stat_guestsperhour"]');
const stat_RegistrationsPerHourHolder = document.querySelector('[data-behaviour="stat_registrationsperhour"]');
const stat_GuestsPerDay = [];
const stat_GuestsPerHour = [];
const stat_RegistrationsPerHour = [];

let dailyChart = null;
let hourlyChart = null;

const optionsTime = { hour: 'numeric', minute: 'numeric' };
const formatterTime = new Intl.DateTimeFormat('de', optionsTime);
const optionsDate = { month: 'numeric', day: 'numeric' };
const formatterDate = new Intl.DateTimeFormat('de', optionsDate);

//Check if statPage exists
if (statPage) {
    console.log('Statistics Page');
    renderStatistics();
    //update statistics every 5 minutes
    setInterval(updateStatistics, 3000);
}

function renderStatistics() {
    getTotalGuestsThisYear();
    getGuestsPerDay();
    getRegistrationsPerHour();
    getGuestsPerHour();
}

function getTotalGuestsThisYear() {
    //get total guests this year from api
    fetch('./api/statistics?type=GuestsThisYear')
        .then(response => response.json())
        .then(data => {
            stat_totalGuests.innerHTML = data["GuestsThisYear"].TT;
        });
}

function getGuestsPerDay() {
    stat_GuestsPerDay.length = 0;
    fetch('./api/statistics?type=GuestsPerDay')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const days = Object.keys(data);

            //Get array of guests per day from data
            const guests = Object.values(data);

            //Create array of objects with day and guests
            days.forEach((day, index) => {
                stat_GuestsPerDay.push({
                    day: day,
                    guests: guests[index].TT,
                    formattedDate: formatterDate.format(new Date(day)),
                    formattedTime: formatterTime.format(new Date(day))
                });
            });

            //Render guests per day
            renderGuestsPerDay();
        });
}

function getGuestsPerHour() {
    stat_GuestsPerHour.length = 0;
    fetch('./api/statistics?type=GuestsPerHour')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const hours = Object.keys(data);

            //Get array of guests per day from data
            const guests = Object.values(data);

            //Create array of objects with day and guests
            hours.forEach((hour, index) => {
                stat_GuestsPerHour.push({
                    hour: hour,
                    guests: guests[index].TT,
                    formattedTime: formatterTime.format(new Date(hour)),
                    formattedDate: formatterDate.format(new Date(hour))
                });
            });

            //fill missing hours with 0 guests
            const firstHour = new Date(stat_GuestsPerHour[0].hour);
            const lastHour = new Date(stat_GuestsPerHour[stat_GuestsPerHour.length - 1].hour);
            const currentHour = new Date(firstHour);
            while (currentHour < lastHour) {
                const currentHourString = currentHour.toISOString();
                if (!stat_GuestsPerHour.find(entry => entry.hour === currentHourString)) {
                    stat_GuestsPerHour.push({
                        hour: currentHourString,
                        guests: 0,
                        formattedTime: formatterTime.format(new Date(currentHourString)),
                        formattedDate: formatterDate.format(new Date(currentHourString))
                    });
                }
                currentHour.setHours(currentHour.getHours() + 1);
            }

            stat_GuestsPerHour.sort((a, b) => {
                return new Date(a.hour) - new Date(b.hour);
            });


            //Render guests per day
            renderGuestsPerHour();
        });
}

function getRegistrationsPerHour() {
    stat_RegistrationsPerHour.length = 0;

    fetch('./api/statistics?type=RegistrationsPerHour')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const hours = Object.keys(data);

            //Get array of guests per day from data
            const registrations = Object.values(data);

            //Create array of objects with day and guests
            hours.forEach((hour, index) => {
                stat_RegistrationsPerHour.push({
                    hour: hour,
                    registrations: registrations[index],
                    formattedTime: formatterTime.format(new Date(hour)),
                    formattedDate: formatterDate.format(new Date(hour))
                });
            });

            //fill missing hours with 0 guests
            const firstHour = new Date(stat_RegistrationsPerHour[0].hour);
            const lastHour = new Date(stat_RegistrationsPerHour[stat_RegistrationsPerHour.length - 1].hour);
            const currentHour = new Date(firstHour);
            while (currentHour < lastHour) {
                const currentHourString = currentHour.toISOString();
                if (!stat_RegistrationsPerHour.find(entry => entry.hour === currentHourString)) {
                    stat_RegistrationsPerHour.push({
                        hour: currentHourString,
                        registrations: 0,
                        formattedTime: formatterTime.format(new Date(currentHourString)),
                        formattedDate: formatterDate.format(new Date(currentHourString))
                    });
                }
                currentHour.setHours(currentHour.getHours() + 1);
            }

            stat_RegistrationsPerHour.sort((a, b) => {
                return new Date(a.hour) - new Date(b.hour);
            });

            //Render guests per day
            renderRegistrationsPerHour();
        });
}

function renderGuestsPerDay() {
    stat_GuestsPerDayHolder.innerHTML = '';
    stat_GuestsPerDay.forEach(day => {
        if (day.guests === 0) {
            return;
        }

        stat_GuestsPerDayHolder.innerHTML += `
            <div class="statistics_entry">
                <p class="entry_value">${day.guests}</p>
                <p class="entry_title">${day.formattedDate}</p>
            </div>
        `;
    });

    if (dailyChart != null) {
        dailyChart.update();
    } else {
        dailyChart = new Chart(
            document.getElementById('dailyCharts'),
            {
                type: 'bar',
                data: {
                    labels: stat_GuestsPerDay.map(row => row.day),
                    datasets: [
                        {
                            label: 'Guests per day',
                            data: stat_GuestsPerDay.map(row => row.guests)
                        }
                    ]
                }
            }
        );
    }
}

function renderRegistrationsPerHour() {
    stat_RegistrationsPerHourHolder.innerHTML = '';
    stat_RegistrationsPerHour.forEach(entry => {
        if (entry.registrations === 0) {
            return;
        }

        stat_RegistrationsPerHourHolder.innerHTML += `
            <div class="statistics_entry">
                <p class="entry_value">${entry.registrations}</p>
                <p class="entry_title">${entry.formattedDate}</p>
                <p class="entry_title">${entry.formattedTime}</p>
            </div>
        `;
    });

    renderHourlyGraph();
}

function renderGuestsPerHour() {
    stat_GuestsPerHourHolder.innerHTML = '';
    stat_GuestsPerHour.forEach(entry => {
        if (entry.guests === 0) {
            return;
        }

        stat_GuestsPerHourHolder.innerHTML += `
            <div class="statistics_entry">
                <p class="entry_value">${entry.guests}</p>
                <p class="entry_title">${entry.formattedDate}</p>
                <p class="entry_title">${entry.formattedTime}:00</p>
            </div>
        `;
    });

    renderHourlyGraph();
}

function renderHourlyGraph()
{
    if(stat_GuestsPerHour.length > 0 && stat_RegistrationsPerHour.length > 0)
    {
        if (hourlyChart != null) {
            hourlyChart.update();
        } else {
            hourlyChart = new Chart(
                document.getElementById('hourlyCharts'),
                {
                    type: 'line',
                    data: {
                        labels: stat_GuestsPerHour.map(row => row.hour),
                        datasets: [
                            {
                                label: 'Guests per hour',
                                data: stat_GuestsPerHour.map(row => row.guests)
                            }, {
                                label: 'Registrations per hour',
                                data: stat_RegistrationsPerHour.map(row => row.registrations)
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                min: stat_GuestsPerHour[0].hour,
                                max: stat_RegistrationsPerHour[stat_RegistrationsPerHour.length - 1].hour,
                                type: 'time',
                                time: {
                                    displayFormats: {
                                        hour: 'DD.MM hh:mm'
                                    }
                                },
                            }
                        }
                    },
                }
            );
        }
    }
}

function updateStatistics() {
    getTotalGuestsThisYear();
    getGuestsPerDay();
    getRegistrationsPerHour();
    getGuestsPerHour();
}
