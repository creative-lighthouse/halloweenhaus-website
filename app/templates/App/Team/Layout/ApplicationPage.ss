<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$Title</title>
    $MetaTags
</head>
<body>
    <hr style="margin-top: 90px">
    <section class="section--ApplicationPage">
        <div class="section_content">
            <% if $Success %>
                <div class="section_title">
                    <h1 class="hl1">Vielen Dank für deine Bewerbung!</h1>
                </div>

                <div class="application_success">
                    <h3>Wir haben deine Bewerbung erhalten</h3>
                    <p>Wir werden uns in Kürze bei dir melden und dich über die nächsten Schritte informieren.</p>
                    
                    <div class="success_info">
                        <h4>Wie geht es weiter?</h4>
                        <ul>
                            <li>Wir prüfen deine Bewerbung innerhalb der nächsten 7 Tage</li>
                            <li>Bei Interesse laden wir dich zu einem Kennenlerngespräch ein</li>
                            <li>Du kannst uns jederzeit per E-Mail kontaktieren</li>
                        </ul>
                    </div>
                    
                    <p><a href="/" class="button">Zurück zur Startseite</a></p>
                </div>
            <% else %>
                <div class="section_title">
                    <h1 class="hl1">Bewerbung - Team Halloweenhaus</h1>
                </div>

                <div class="section_intro">
                    <p>Hier kannst du weitere Informationen über die Bewerbung bei uns finden.</p>
                    <p>Das Bewerbungsformular findest du auf unserer <a href="/">Startseite</a>.</p>
                </div>
            <% end_if %>
        </div>
    </section>
</body>
</html>
