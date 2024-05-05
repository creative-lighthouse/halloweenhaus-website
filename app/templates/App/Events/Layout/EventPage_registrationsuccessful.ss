<div class="section section--events">
    <div class="section_content">
        <div class="event_text">
            <h1>$Title</h1>
            <hr>
            <h2>Anmeldung erfolgreich!</h2>
            <h3>Hey $Registration.Title!</h3>
            <h4>Du bist erfolgreich für <b>"$Event.Title"</b> am <b>$Event.DateFormatted</b> um <b>$Registration.TimeSlot.SlotTimeFormatted</b> angemeldet.</h4>
            <p>Sei bitte mindestens 5 Minuten vor deinem gebuchten Slot vor Ort ($Event.Place), damit wir pünktlich starten können.
            Wir senden dir außerdem eine Email mit einer Anmeldebestätigung und einem Code zum Vorzeigen vor dem Eingang.</p>
            <% if $Registration.GroupSize == 1 %>
                <p>Wir freuen uns auf dich!</p>
            <% else %>
                <p>Wir freuen uns auf euch $Registration.GroupSize!</p>
            <% end_if %>
        </div>
    </div>
</div>
