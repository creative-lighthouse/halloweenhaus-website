<div class="section section--events">
    <div class="section_content">
        <h1>$Title</h1>

        <div class="events_list">
            <% loop $Events %>
            <div class="event_entry" <% if $Image %> style="background-image: url($Image.AbsoluteUrl);" <% end_if %>>
                    <h2>$Title</h2>
                    <p>$StartTime.Nice</p>
                    <% if $RemainingSeats > 0 %><p>Noch $RemainingSeats Plätze</p>
                        <% else %><p>Ausgebucht!</p><% end_if %>
                    <a class="link--button" href="$RegistrationLink">Jetzt registrieren</a>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
