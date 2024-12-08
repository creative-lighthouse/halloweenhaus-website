<div class="section section--events registrationconfirm">
    <div class="section_content">
        <div class="event_text">
            <h1>$Title</h1>
            <hr>
            <h2>Deine Anmeldung ist abgeschlossen, $Registration.Title</h2>
            <h4>Deine Buchung für <b>"$Event.Title"</b> am <b>$Event.DateFormatted</b> um <b>$Registration.TimeSlot.SlotTimeFormatted</b> ist erfolgreich bestätigt.</h4>
            <p>Sei bitte mindestens 5 Minuten vor deinem gebuchten Slot vor Ort ($Event.Place), damit wir pünktlich starten können.
            Vor Ort kannst Du uns das folgende Ticket für Dich und deine Gruppe am Eingang zeigen:</p>
            <h3><a class="ticket_button" href="$Registration.TicketLink">Ticket anzeigen</a></h3>
            <p>Dein Ticket ist auch in deinem Email-Postfach.</p>
            <% if $Registration.GroupSize == 1 %>
                <p>Wir freuen uns auf dich</p>
            <% else %>
                <p>Wir freuen uns auf euch {$Registration.GroupSize}.</p>
            <% end_if %>
        </div>
    </div>
</div>
