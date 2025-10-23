<div class="section section--StatisticsPage statistics-page">
    <div class="section_content">
        <h1>Statistiken</h1>

        <div class="statistics_row">
            <div class="statistics_entry">
                <p class="entry_value" data-behaviour="stat_totalthisyear">???</p>
                <p class="entry_title">Gäste Gesamt dieses Jahr</p>
            </div>
        </div>

        <hr>
        <h2>Registrierungen</h2>
        <h3>Herkunft pro PLZ</h3>
        <div class="statistics_row">
            <% loop $OriginRegistrationThisYear %>
                <div class="statistics_entry">
                    <p class="entry_value">$ZIP</p>
                    <p class="entry_title">$Number</p>
                </div>
            <% end_loop %>
        </div>        

        <h3>Registrierungen pro Tag</h3>
        <div class="statistics_row" data-behaviour="stat_registrationsperday">
            <div class="statistics_entry">
                <p class="entry_value">???€</p>
                <p class="entry_title">??.??.</p>
            </div>
        </div>

        <div class="statistics_row">
            <div class="statistics_entry">
                <canvas id="dailyCharts"></canvas>
            </div>
        </div>
        
        <hr>
        <h2>Feedback</h2>
        <h3>Durchschnittliche Bewertung</h3>
        <div class="statistics_row">
            <% loop $RatingPerDay %>
            <div class="statistics_entry">
                <p class="entry_value">$AverageStars Sterne</p>
                <p class="entry_title">$Day</p>
            </div>
            <% end_loop %>
        </div>
        
        <h3>Herkunft pro PLZ</h3>
        <div class="statistics_row">
            <% loop $OriginFeedbackThisYear %>
                <div class="statistics_entry">
                    <p class="entry_value">$ZIP</p>
                    <p class="entry_title">$Number</p>
                </div>
            <% end_loop %>
        </div>

        <h3>Kommentare</h3>
        <div class="statistics_row">
            <% loop $FeedbackComments %>
                <div class="statistics_entry">
                    <p class="entry_title">$Comment <br>$Day.Nice</p>
                </div>
            <% end_loop %>
        </div>

        <hr>
        <h2>Tägliche Statistiken</h2>
        <h3>Gäste pro Tag</h3>
        <div class="statistics_row" data-behaviour="stat_guestsperday">
            <div class="statistics_entry">
                <p class="entry_value">???</p>
                <p class="entry_title">??.??.</p>
            </div>
        </div>

        <h3>Verkäufe pro Tag</h3>
        <div class="statistics_row" data-behaviour="stat_salesperday">
            <div class="statistics_entry">
                <p class="entry_value">???</p>
                <p class="entry_title">??.??.</p>
            </div>
        </div>

        <h3>Einnahmen pro Tag</h3>
        <div class="statistics_row" data-behaviour="stat_profitsperday">
            <div class="statistics_entry">
                <p class="entry_value">???€</p>
                <p class="entry_title">??.??.</p>
            </div>
        </div>

        <hr>
        <h2>Stündliche Statistiken</h2>
        <h3>Gäste pro Stunde</h3>
        <div class="statistics_row" data-behaviour="stat_guestsperhour">
            <div class="statistics_entry">
                <p class="entry_value">???</p>
                <p class="entry_title">??:??</p>
            </div>
        </div>


        <h3>Registrierungen pro Stunde</h3>
        <div class="statistics_row" data-behaviour="stat_registrationsperhour">
            <div class="statistics_entry">
                <p class="entry_value">???</p>
                <p class="entry_title">??:??</p>
            </div>
        </div>

        <h3>Verkäufe pro Stunde</h3>
        <div class="statistics_row" data-behaviour="stat_salesperhour">
            <div class="statistics_entry">
                <p class="entry_value">???</p>
                <p class="entry_title">??:??</p>
            </div>
        </div>

        <div class="statistics_row">
            <div class="statistics_entry">
                <canvas id="hourlyCharts"></canvas>
            </div>
        </div>
    </div>
</div>
