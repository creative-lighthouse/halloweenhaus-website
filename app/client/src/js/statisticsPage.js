import Chart from 'chart.js/auto';
import 'chartjs-adapter-moment';

const statPage = document.querySelector('.statistics-page');
const stat_totalGuests = document.querySelector('[data-behaviour="stat_totalthisyear"]');
const stat_GuestsPerDayHolder = document.querySelector('[data-behaviour="stat_guestsperday"]');
const stat_SalesPerDayHolder = document.querySelector('[data-behaviour="stat_salesperday"]');
const stat_ProfitsPerDayHolder = document.querySelector('[data-behaviour="stat_profitsperday"]');
const stat_RegistrationsPerDayHolder = document.querySelector('[data-behaviour="stat_registrationsperday"]');
const stat_GuestsPerHourHolder = document.querySelector('[data-behaviour="stat_guestsperhour"]');
const stat_RegistrationsPerHourHolder = document.querySelector('[data-behaviour="stat_registrationsperhour"]');
const stat_SalesPerHourHolder = document.querySelector('[data-behaviour="stat_salesperhour"]');

//Daily Stats
const stat_GuestsPerDay = [];
const stat_SalesPerDay = [];
const stat_ProfitsPerDay = [];
const stat_RegistrationsPerDay = [];

//Hourly Stats
const stat_GuestsPerHour = [];
const stat_RegistrationsPerHour = [];
const stat_SalesPerHour = [];

let dailyChart = null;
let hourlyChart = null;

const optionsTime = { hour: 'numeric', minute: 'numeric' };
const formatterTime = new Intl.DateTimeFormat('de', optionsTime);
const optionsDate = { month: 'numeric', day: 'numeric' };
const formatterDate = new Intl.DateTimeFormat('de', optionsDate);

var registrationsPerHourLoaded = false;
var guestsPerHourLoaded = false;
var salesPerHourLoaded = false;
var guestsPerDayLoaded = false;
var salesPerDayLoaded = false;
var profitsPerDayLoaded = false;
var registrationsPerDayLoaded = false;

//Check if statPage exists
if (statPage) {
    console.log('Statistics Page');
    updateStatistics();
    //update statistics every 5 minutes
    setInterval(updateStatistics, 30000);
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

            //sort by date
            stat_GuestsPerDay.sort((a, b) => {
                return new Date(a.day) - new Date(b.day);
            });

            guestsPerDayLoaded = true;

            //Render guests per day
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

            renderDailyGraph();
        });
}

function getRegistrationsPerDay() {
    stat_RegistrationsPerDay.length = 0;
    fetch('./api/statistics?type=RegistrationsPerDay')
        .then(response => response.json())
        .then(data => {
            //Get array of days from data
            const days = Object.keys(data);

            //Get array of guests per day from data
            const registrations = Object.values(data);

            //Create array of objects with day and guests
            days.forEach((day, index) => {
                stat_RegistrationsPerDay.push({
                    day: day,
                    registrations: registrations[index],
                    formattedDate: formatterDate.format(new Date(day)),
                    formattedTime: formatterTime.format(new Date(day))
                });
            });

            //sort by date
            stat_RegistrationsPerDay.sort((a, b) => {
                return new Date(a.day) - new Date(b.day);
            });

            registrationsPerDayLoaded = true;

            //Render guests per day
            stat_RegistrationsPerDayHolder.innerHTML = '';
            stat_RegistrationsPerDay.forEach(day => {
                if (day.registrations === 0) {
                    return;
                }

                stat_RegistrationsPerDayHolder.innerHTML += `
                    <div class="statistics_entry">
                        <p class="entry_value">${day.registrations}</p>
                        <p class="entry_title">${day.formattedDate}</p>
                    </div>
                `;
            });

            renderDailyGraph();
        });
}

function getProfitsPerDay() {
    stat_ProfitsPerDay.length = 0;
    fetch('./api/statistics?type=ProfitsPerDay')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const days = Object.keys(data);

            //Get array of guests per day from data
            const profits = Object.values(data);

            //Create array of objects with day and guests
            days.forEach((day, index) => {
                stat_ProfitsPerDay.push({
                    day: day,
                    profits: profits[index],
                    formattedDate: formatterDate.format(new Date(day)),
                    formattedTime: formatterTime.format(new Date(day))
                });
            });

            //sort by date
            stat_ProfitsPerDay.sort((a, b) => {
                return new Date(a.day) - new Date(b.day);
            });

            profitsPerDayLoaded = true;

            //Render guests per day
            stat_ProfitsPerDayHolder.innerHTML = '';
            stat_ProfitsPerDay.forEach(day => {
                if (day.profits === 0) {
                    stat_ProfitsPerDayHolder.innerHTML += `
                        <div class="statistics_entry">
                            <p class="entry_value">Nur Spenden</p>
                            <p class="entry_title">${day.formattedDate}</p>
                        </div>
                    `;
                    return;
                }

                stat_ProfitsPerDayHolder.innerHTML += `
                    <div class="statistics_entry">
                        <p class="entry_value">${day.profits} €</p>
                        <p class="entry_title">${day.formattedDate}</p>
                    </div>
                `;
            });

            renderDailyGraph();
        });
}

function getSalesPerDay() {
    stat_SalesPerDay.length = 0;
    fetch('./api/statistics?type=SalesPerDay')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const days = Object.keys(data);

            //Get array of guests per day from data
            const sales = Object.values(data);

            //Create array of objects with day and guests
            days.forEach((day, index) => {
                stat_SalesPerDay.push({
                    day: day,
                    sales: sales[index],
                    formattedDate: formatterDate.format(new Date(day)),
                    formattedTime: formatterTime.format(new Date(day))
                });
            });

            //sort by date
            stat_SalesPerDay.sort((a, b) => {
                return new Date(a.day) - new Date(b.day);
            });

            salesPerDayLoaded = true;

            //Render sales per day
            stat_SalesPerDayHolder.innerHTML = '';
            stat_SalesPerDay.forEach(day => {
                if (day.sales === 0) {
                    return;
                }

                stat_SalesPerDayHolder.innerHTML += `
                    <div class="statistics_entry">
                        <p class="entry_value">${day.sales}</p>
                        <p class="entry_title">${day.formattedDate}</p>
                    </div>
                `;
            });

            renderDailyGraph();
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
                const totalGuests = guests[index].TT;
                stat_GuestsPerHour.push({
                    hour: hour,
                    guests: totalGuests,
                    formattedTime: formatterTime.format(new Date(hour)),
                    formattedDate: formatterDate.format(new Date(hour)),
                    simpleDateTime: new Date(hour)
                });
            });

            stat_GuestsPerHour.sort((a, b) => {
                return new Date(a.hour) - new Date(b.hour);
            });

            guestsPerHourLoaded = true;

            //Render guests per day
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
        });
}

function getSalesPerHour() {
    stat_SalesPerHour.length = 0;
    fetch('./api/statistics?type=SalesPerHour')
        .then(response => response.json())
        .then(data => {

            //Get array of days from data
            const hours = Object.keys(data);

            //Get array of guests per day from data
            const sales = Object.values(data);

            //Create array of objects with day and guests
            hours.forEach((hour, index) => {
                stat_SalesPerHour.push({
                    hour: hour,
                    sales: sales[index],
                    formattedTime: formatterTime.format(new Date(hour)),
                    formattedDate: formatterDate.format(new Date(hour)),
                    simpleDateTime: new Date(hour)
                });
            });

            //Add 0 sales for every hour that has no sales
            const hoursInDay = 24;
            for (let i = 0; i < hoursInDay; i++) {
                const hour = i.toString().padStart(2, '0');
                const hourExists = stat_SalesPerHour.some(entry => entry.hour === hour);
                if (!hourExists) {
                    stat_SalesPerHour.push({
                        hour: hour,
                        sales: 0,
                        formattedTime: hour + ':00',
                        formattedDate: formatterDate.format(new Date(hour)),
                        simpleDateTime: new Date(hour)
                    });
                }
            }

            stat_SalesPerHour.sort((a, b) => {
                return new Date(a.hour) - new Date(b.hour);
            });

            salesPerHourLoaded = true;

            //Render sales per hour
            stat_SalesPerHourHolder.innerHTML = '';
            stat_SalesPerHour.forEach(entry => {
                if (entry.sales === 0) {
                    return;
                }

                stat_SalesPerHourHolder.innerHTML += `
                    <div class="statistics_entry">
                        <p class="entry_value">${entry.sales}</p>
                        <p class="entry_title">${entry.formattedDate}</p>
                        <p class="entry_title">${entry.formattedTime}</p>
                    </div>
                `;
            });

            renderHourlyGraph();
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
                    formattedDate: formatterDate.format(new Date(hour)),
                    simpleDateTime: new Date(hour)
                });
            });

            stat_RegistrationsPerHour.sort((a, b) => {
                return new Date(a.hour) - new Date(b.hour);
            });

            registrationsPerHourLoaded = true;

            //Render guests per day
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
        });
}

///GRAPHS
function renderHourlyGraph()
{
    if (!registrationsPerHourLoaded || !guestsPerHourLoaded || !salesPerHourLoaded) {
        return;
    }

    if (hourlyChart != null) {
        hourlyChart.data.datasets = buildHourlyData();
        hourlyChart.update();
    } else {
        //create simple arrays for chart.js with only simpleDateTime and guests/registrations
        hourlyChart = new Chart(
            document.getElementById('hourlyCharts'),
            {
                type: 'line',
                data: { datasets: buildHourlyData() },
                options: {
                    scales: {
                        xAxes: {
                            type: 'time',
                            min: stat_SalesPerHour[0].simpleDateTime,
                            max: stat_SalesPerHour[stat_SalesPerHour.length - 1].simpleDateTime,
                            time: {
                                unit: 'hour',
                                displayFormats: { hour: 'hh:00' },
                            }
                        }
                    }
                },
            }
        );
    }
}

function renderDailyGraph()
{
    if (!guestsPerDayLoaded || !salesPerDayLoaded || !profitsPerDayLoaded || !registrationsPerDayLoaded) {
        return;
    }

    if (dailyChart != null) {
        dailyChart.data.datasets = buildDailyData();
        dailyChart.update();
    } else {
        dailyChart = new Chart(
            document.getElementById('dailyCharts'),
            {
                type: 'bar',
                data: { datasets: buildDailyData() },
                options: {
                    scales: {
                        xAxes: {
                            type: 'time',
                            min: stat_GuestsPerDay[0].day,
                            max: stat_GuestsPerDay[stat_GuestsPerDay.length - 1].day,
                            time: {
                                unit: 'day',
                                displayFormats: { day: 'DD.MM.' }
                            }
                        }
                    }
                },
            }
        );
    }
}

///BUILD DATA FOR GRAPHS
function buildHourlyData()
{
    if (stat_GuestsPerHour.length > 0) {
        var guestsPerHourArray = stat_GuestsPerHour.map(row => { return { x: row.simpleDateTime, y: row.guests } });
    } else {
        var guestsPerHourArray = [];
    }

    if(stat_RegistrationsPerHour.length > 0) {
        var registrationsPerHourArray = stat_RegistrationsPerHour.map(row => { return { x: row.simpleDateTime, y: row.registrations } });
    } else {
        var registrationsPerHourArray = [];
    }

    if(stat_SalesPerHour.length > 0) {
        var salesPerHourArray = stat_SalesPerHour.map(row => { return { x: row.simpleDateTime, y: row.sales } });
    } else {
        var salesPerHourArray = [];
    }

    var guestsPerHourData = {
        label: 'Gäste pro Stunde',
        data: guestsPerHourArray
    }
    var registrationsPerHourData = {
        label: 'Registrierungen pro Stunde',
        data: registrationsPerHourArray
    }
    var salesPerHourData = {
        label: 'Verkäufe pro Stunde',
        data: salesPerHourArray
    }

    return [guestsPerHourData, registrationsPerHourData, salesPerHourData];
}

function buildDailyData()
{
    var guestsPerDayArray = stat_GuestsPerDay.map(row => { return { x: row.day, y: row.guests } });
    var salesPerDayArray = stat_SalesPerDay.map(row => { return { x: row.day, y: row.sales } });
    var profitsPerDayArray = stat_ProfitsPerDay.map(row => { return { x: row.day, y: row.profits } });
    var registrationsPerDayArray = stat_RegistrationsPerDay.map(row => { return { x: row.day, y: row.registrations } });

    var guestsPerDayData = {
        type: 'bar',
        label: 'Gäste pro Tag',
        data: guestsPerDayArray
    }
    var salesPerDayData = {
        type: 'bar',
        label: 'Verkäufe pro Tag',
        data: salesPerDayArray
    }
    var profitsPerDayData = {
        type: 'line',
        label: 'Einnahmen pro Tag',
        data: profitsPerDayArray
    }
    var registrationsPerDayData = {
        type: 'line',
        label: 'Registrierungen pro Tag',
        data: registrationsPerDayArray
    }

    return [guestsPerDayData, salesPerDayData, profitsPerDayData, registrationsPerDayData];
}

function updateStatistics() {
    getTotalGuestsThisYear();
    getGuestsPerDay();
    getSalesPerDay();
    getRegistrationsPerHour();
    getGuestsPerHour();
    getSalesPerHour();
    getProfitsPerDay();
    getRegistrationsPerDay();
}
