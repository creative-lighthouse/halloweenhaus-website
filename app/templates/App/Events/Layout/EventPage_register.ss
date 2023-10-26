
    <div class="section section--events">
        <div class="section_content">
            <a class="link--button" href="$Link">← Zurück zur Übersicht</a>
            <% with $Event %>
                <% if $Image %><img class="event_details_image" src="$Image.FocusFill(1200, 400).URL" alt="$Image.Title" /><% end_if %>
                <h2>Anmeldung für $Title</h2>
                <h3>$StartTime.Nice <% if $EndTime %>- $EndTime.Nice <% end_if %></h3>

                <p>Bitte fülle das untenstehende Formular vollständig aus, um Dich für $Title anzumelden. Alle Felder sind Pflichfelder.</p>

                $Top.RegistrationForm($ID)

            <% end_with %>
    </div>
</div>
