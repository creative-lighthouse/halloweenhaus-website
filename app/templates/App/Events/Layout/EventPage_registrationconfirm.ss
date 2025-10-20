<div class="section section--events registrationconfirm">
    <div class="section_content">
        <div class="event_text">
            <h2 class="event-statustitle">Deine Buchung ist erfolgreich bestätigt</h2>
            <div class="event-box event_details">
                <p class="call-to-action">Sei bitte mindestens 5 Minuten vor deinem Slot vor Ort:</p>
                <p class="eventplace"><% if $Event.PlaceLink %><a href="$Event.PlaceLink">$Event.Place</a><% else %>$Event.Place<% end_if %></p>
                <p>Nutze am Eingang dein Ticket:</p>

                <a class="link--button" href="$Registration.TicketLink">Ticket anzeigen</a>
                <p class="hint">Dein Ticket ist auch in deinem Email-Postfach.</p>
            </div>
            <div class="event-box booked-event">
                <h3 class="booked-event-title">Dein gebuchter Zeitslot:</h3>
                <p>$Event.Title • $Event.DateFormatted $Registration.TimeSlot.SlotTimeFormatted</p>
                <p>$Registration.GroupSize <% if $Registration.GroupSize > 1 %>Personen<% else %>Person<% end_if %></p>
            </div>
            <div class="event-box important-info">
                Bitte stelle Dich vor Ort in der gesonderten Warteschlange "Ottos Sondereingang" an und zeige beim Einlass dein Ticket vor.<br>
                Falls Du doch nicht mehr kommen willst oder kannst, melde dich bitte über <a href="$Registration.UnsubscribeLink">diesen Link</a> ab.<br>
                Du hast noch eine Frage? - Wir haben vielleicht schon eine Antwort: Alles Wichtige steht in unseren <a href="https://halloweenhaus-schmalenbeck.de/faq">FAQs</a>.</p>
                <p>Zum Abschluss noch ein Tipp: Für unsere Show benötigt deine Gruppe einen Halloweenspruch.</p>
            </div>
            <div class="greetings">
                <% if $Registration.GroupSize == 1 %>
                    <p>Wir freuen uns auf dich</p>
                <% else %>
                    <p>Wir freuen uns auf euch {$Registration.GroupSize}.</p>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
