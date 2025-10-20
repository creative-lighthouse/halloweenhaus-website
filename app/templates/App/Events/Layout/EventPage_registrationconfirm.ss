<div class="section section--events registrationconfirm">
    <div class="section_content">
        <div class="event_text">
            <h1>$Title</h1>
            <hr>
            <h2>Deine Anmeldung ist abgeschlossen, $Registration.Title</h2>
            <h4>Deine Buchung für <b>"$Event.Title"</b> am <b>$Event.DateFormatted</b> um <b>$Registration.TimeSlot.SlotTimeFormatted</b> ist erfolgreich bestätigt.</h4>
            <p>Sei bitte mindestens 5 Minuten vor deinem gebuchten Slot vor Ort ($Event.Place) und nutze beim Einlass dein Ticket:</p>

            <h3><a class="ticket_button" href="$Registration.TicketLink">Ticket anzeigen</a></h3>
            <p>Dein Ticket ist auch in deinem Email-Postfach.</p>

            <p>Das Halloweenhaus Schmalenbeck findet hier statt: <strong>Deepenstegen 25A, 22952 Lütjensee</strong><br>
            Bitte stelle Dich vor Ort in der gesonderten Warteschlange "Ottos Sondereingang" an und zeige beim Einlass dein Ticket vor.<br>
            Falls Du doch nicht mehr kommen willst oder kannst, melde dich bitte über <a href="$Registration.UnsubscribeLink">diesen Link</a> ab.<br>
            Du hast noch eine Frage? - Wir haben vielleicht schon eine Antwort: Alles Wichtige steht in unseren <a href="https://halloweenhaus-schmalenbeck.de/faq">FAQs</a>.</p>
            <p>Zum Abschluss noch ein Tipp: Für unsere Show benötigt deine Gruppe einen Halloweenspruch.</p>
            <% if $Registration.GroupSize == 1 %>
                <p>Wir freuen uns auf dich</p>
            <% else %>
                <p>Wir freuen uns auf euch {$Registration.GroupSize}.</p>
            <% end_if %>
        </div>
    </div>
</div>
