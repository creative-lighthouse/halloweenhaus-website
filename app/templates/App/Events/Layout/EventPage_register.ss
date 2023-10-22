
    <div class="section section--events">
        <div class="section_content">
            <h1>$Title</h1>

            <% with $Event %>
                <h2>Anmeldung für $Title</h2>
                <h3>$StartTime.Nice <% if $EndTime %>- $EndTime.Nice <% end_if %></h3>

                <p>Bitte fülle das untenstehende Formular vollständig aus, um Dich für $Title anzumelden. Alle mit * gekennzeichneten Felder sind Pflichfelder.</p>

                $Top.RegistrationForm($ID)

            <% end_with %>
    </div>
</div>
