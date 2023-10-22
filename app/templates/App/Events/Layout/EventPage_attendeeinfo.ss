<div class="section section--events">
    <div class="section_content">
        <h1>Deine Registrierung</h1>
        <% with $Event %>
            <% if $Image %><img class="event_details_image" src="$Image.FocusFill(1200, 400).URL" alt="$Image.Title" /><% end_if %>
            <h2>Registrierung für $Title am $StartTime.Nice <% if $EndTime %>- $EndTime.Nice <% end_if %></h2>
            <div>$Description</div>
        <% end_with %>
        <hr>
        <h2>Deine Daten:</h2>
        <% with $Registration %>
            <p>Dein Name: $Title</p>
            <p>Deine E-Mail: $Email</p>
        <% end_with %>
    </div>
</div>
