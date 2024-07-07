<div class="section section--events">
    <div class="section_content">
        <a class="link--button" href="$Link">← Zurück zur Übersicht</a>
        <% with $Event %>
            <% if $Image %><img class="event_details_image" src="$Image.FocusFill(1200, 400).URL" alt="$Image.Title" /><% end_if %>
            <h1>$Title</h1>
            <h3>$StartTime.Nice <% if $EndTime %>- $EndTime.Nice <% end_if %></h3>
            <div>$Description</div>
            <a class="link--button event_registration" href="$RegistrationLink">Jetzt registrieren →</a>
        <% end_with %>
    </div>
</div>
