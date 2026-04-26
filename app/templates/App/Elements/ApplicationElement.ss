<section class="section--ApplicationElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <div class="section_title">
                <h2 class="hl2">$Title</h2>
            </div>
        <% end_if %>

        <% if $Text %>
            <div class="section_text">
                $Text
            </div>
        <% end_if %>

        <% if $ApplicationSubmitted %>
            <div class="application_success">
                <% if $SuccessText %>
                    $SuccessText
                <% else %>
                    <h3>Vielen Dank für deine Bewerbung!</h3>
                    <p>Wir haben deine Bewerbung erhalten und werden uns in Kürze bei dir melden.</p>
                <% end_if %>
            </div>
        <% else %>
            <% if $ApplicationError %>
                <div class="application_error">
                    <p class="error">$ApplicationError</p>
                </div>
            <% end_if %>

            <form class="application_form" method="POST" action="$Link/submitApplication">
                $SecurityID

                <input class="field field_name" type="text" name="Title" placeholder="Vor- & Nachname" required>

                <input class="field field_birthday" type="date" name="Birthday" placeholder="Geburtstag" required>

                <input class="field field_email" type="email" name="Email" placeholder="E-Mail" required>

                <textarea class="field field_hobbies" name="Hobbies" placeholder="Was sind deine Hobbys, Talente & Interessen?" required></textarea>

                <textarea class="field field_reason" name="ReasonToJoin" placeholder="Warum willst du ins Team von Ottos Halloweenhaus?" required></textarea>

                <div class="field field_interests">
                    <p>Wofür interessierst du dich? (Mehrfachauswahl möglich)</p>
                    <% loop $Interests %>
                        <label class="checkbox_label">
                            <input type="checkbox" name="Interests[]" value="$ID">
                            $Title
                        </label>
                    <% end_loop %>
                </div>

                <button class="submit_button" type="submit">Jetzt bewerben</button>
            </form>
        <% end_if %>
    </div>
</section>
