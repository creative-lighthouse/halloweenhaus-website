<% if $Character %>
    <% with $Character %>
        <a href="$Character.Link" class="charactercard" style="view-transition-name: charactercard-$ID;">
            <div class="charactercard_image" style="view-transition-name: characterimage-$ID;">
                <% if $Character.Image %>
                    $Character.Image.FocusFill(200,200)
                <% else %>
                    <img src="_resources/app/client/images/placeholder-image.jpg" alt="Kein Bild verfügbar" style="width: 100%; height: 100%; object-fit: cover;">
                <% end_if %>
            </div>
            <div class="charactercard_content">
                <h3 class="charactercard_name">$Character.Title</h3>
                <% if $Character.ShortDescription %><p class="charactercard_shortdescription">$Character.ShortDescription</p><% end_if %>
                <% if $Character.Jointime %><p class="charactercard_jointime"><b>Erstauftritt:</b> $Character.Jointime</p><% end_if %>
                <% if $Character.Type == 'animatronic' %>
                        <p class="character_actorlist_title title--animatronic">Animatronik</p>
                <% else %>
                    <% if $Top.Children.Count > 0 %>
                        <p class="character_actorlist_title">Gespielt von:</p>
                        <div class="character_actorlist">
                            <% loop $Top.Children %>
                                <div class="character_actor">
                                    $TeamMember.Image
                                    <p>$TeamMember.Title</p>
                                </div>
                            <% end_loop %>
                        </div>
                    <% end_if %>
                <% end_if %>
            </div>
        </a>
    <% end_with %>
<% else %>
    <a href="$Link" class="charactercard" style="view-transition-name: charactercard-$ID;">
        <div class="charactercard_image" style="view-transition-name: characterimage-$ID;">
            <% if $Image %>
                $Image.FocusFill(200,200)
            <% else %>
                <img src="_resources/app/client/images/placeholder-image.jpg" alt="Kein Bild verfügbar" style="width: 100%; height: 100%; object-fit: cover;">
            <% end_if %>
        </div>
        <div class="charactercard_content">
            <h3 class="charactercard_name">$Title</h3>
            <% if $ShortDescription %><p class="charactercard_shortdescription">$ShortDescription</p><% end_if %>
            <% if $Jointime %><p class="charactercard_jointime"><b>Erstauftritt:</b> $Jointime</p><% end_if %>
            <% if $Top.Children.Count > 0 %>
                <% if $Type == 'animatronic' %>
                    <p class="character_actorlist_title">Animatronik</p>
                <% else %>
                    <p class="character_actorlist_title">Gespielt von:</p>
                    <div class="character_actorlist">
                        <% loop $Top.Children %>
                            <div class="character_actor">
                                $TeamMember.Image
                                <p>$TeamMember.Title</p>
                            </div>
                        <% end_loop %>
                    </div>
                <% end_if %>
            <% end_if %>
        </div>
    </a>
<% end_if %>
