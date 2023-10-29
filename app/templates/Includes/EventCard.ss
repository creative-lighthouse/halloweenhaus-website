<div class="event_card" <% if $Image %> style="background-image: url($Image.AbsoluteUrl);" <% end_if %>>
    <a href="$Link" class="event_card_content">
        <h2 class="event_title">$Title</h2>
        <div class="event_date">
            <p class="event_date_day">$StartTime.Format("dd.MM.")</p>
            <p class="event_date_year">$StartTime.Format("YYYY")</p>
        </div>
        <p class="event_time">$StartTime.Format("HH:mm")</p>
        <div class="event_description">$ShortDescription</div>
    </a>
    <div class="event_card_footer">
        <% if $RemainingSeats > 0 %>
            <p class="event_seats">Noch $RemainingSeats Plätze</p>
            <a class="link--button event_register" href="$RegistrationLink">Jetzt registrieren →</a>
        <% else %>
            <p class="event_seats full">Ausgebucht!</p>
        <% end_if %>
    </div>
</div>
