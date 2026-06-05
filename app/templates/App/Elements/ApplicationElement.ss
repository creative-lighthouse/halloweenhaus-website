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

            <form class="application_form" method="POST" action="/bewerbung/submit">
                $SecurityID
                <div class="field field_name">
                    <label class="field_label" for="Title">Name:</label>
                    <input class="" type="text" name="Title" autocomplete="name" required value="$SavedFormValues.Title">
                </div>

                <div class="field field_birthday">
                    <label class="field_label" for="Birthday">Geburtstag:</label>
                    <input class="" type="date" name="Birthday" autocomplete="bday" required value="$SavedFormValues.Birthday">
                </div>

                <div class="field field_email">
                    <label class="field_label" for="Email">E-Mail:</label>
                    <input class="field field_email" type="email" name="Email" autocomplete="email" required value="$SavedFormValues.Email">
                </div>

                <div class="field field_hobbies">
                    <label class="field_label" for="Hobbies">Was sind deine Hobbys, Talente & Interessen?</label>
                    <textarea class="field field_hobbies" name="Hobbies" autocomplete="off" required>$SavedFormValues.Hobbies</textarea>
                </div>

                <div class="field field_reason">
                    <label class="field_label" for="ReasonToJoin">Warum willst du ins Team von Ottos Halloweenhaus?</label>
                    <textarea class="field field_reason" name="ReasonToJoin" autocomplete="off" required>$SavedFormValues.ReasonToJoin</textarea>
                </div>

                <div class="field field_interests">
                    <p class="fake-label">Welche Bereiche interessieren dich? (Mehrfachauswahl möglich)</p>
                    <div class="interest_list">
                        <% loop $Interests %>
                            <label class="checkbox_label">
                                <input type="checkbox" name="Interests[]" value="$ID" <% if $Checked %>checked<% end_if %>>
                                $Title
                            </label>
                        <% end_loop %>
                    </div>
                </div>

                <div class="field field_captcha">
                    <label class="field_label" for="Captcha">$CaptchaQuestion = ?</label>
                    <input type="number" id="Captcha" name="Captcha" required>
                </div>

                <div class="field field_send">
                    <% if $CaptchaCooldownSeconds %>
                        <p class="captcha_cooldown">Bitte warte noch <strong><span class="captcha_countdown">$CaptchaCooldownSeconds</span> Sekunden</strong>, bevor du es erneut versuchst.</p>
                    <% end_if %>
                    <button class="link--button button--primary submit_button" type="submit"<% if $CaptchaCooldownSeconds %> disabled data-cooldown="$CaptchaCooldownSeconds"<% end_if %>>Jetzt bewerben</button>
                    <a href="$Datasecuritylink" class="" target="_blank">Datenschutzerklärung</a>
                </div>
            </form>
            <script>
                (function () {
                    var btn = document.querySelector('.submit_button[data-cooldown]');
                    if (!btn) return;
                    var counter = document.querySelector('.captcha_countdown');
                    var remaining = parseInt(btn.dataset.cooldown, 10);
                    var interval = setInterval(function () {
                        remaining--;
                        if (counter) counter.textContent = remaining;
                        if (remaining <= 0) {
                            clearInterval(interval);
                            btn.disabled = false;
                            btn.removeAttribute('data-cooldown');
                            var notice = document.querySelector('.captcha_cooldown');
                            if (notice) notice.remove();
                        }
                    }, 1000);
                })();
            </script>
        <% end_if %>
    </div>
</section>
