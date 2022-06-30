<div class="section section--team_overview">
    <div class="section_content">
        <h1 class="teammember_title">$Title</h1>
        <% if $TeamMembers.Filter("Status", "active").Count > 0 %>
            <h2>Aktuelle</h2>
            <div class="teammember_list">
                <% loop $TeamMembers.Sort("Importance", DESC).Filter("Status", "active") %>
                    <div class="teammember_item">
                        <% if $Description %>
                            <a class="teammember_texts no_deco" href="$Top.Link('view')/$FormattedName">
                                <div class="teammember_item_image">
                                    $Image.FocusFill(400,400)
                                </div>
                                <p class="teammember_item_name">$Title</p>
                                <p class="teammember_item_profession">$Profession</p>
                            </a>
                        <% else %>
                            <div class="teammember_texts no_deco">
                                <div class="teammember_item_image">
                                    $Image.FocusFill(400,400)
                                </div>
                                <p class="teammember_item_name">$Title</p>
                                <p class="teammember_item_profession">$Profession</p>
                            </div>
                        <% end_if %>
                        <div class="social_icons">
                            <% loop $Socials %>
                                <% include SocialIcon %>
                            <% end_loop %>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
        <% if $TeamMembers.Filter("Status", "formerly").Count > 0 %>
            <hr>
            <br>
            <h2>Ehemalige</h2>
            <div class="teammember_list">
                <% loop $TeamMembers.Sort("Importance", DESC).Filter("Status", "formerly") %>
                    <div class="teammember_item">
                        <% if $Description %>
                            <a class="teammember_texts no_deco" href="$Top.Link('view')/$FormattedName">
                                <div class="teammember_item_image">
                                    $Image.FocusFill(400,400)
                                </div>
                                <p class="teammember_item_name">$Title</p>
                                <p class="teammember_item_profession">$Profession</p>
                            </a>
                        <% else %>
                            <div class="teammember_texts no_deco">
                                <div class="teammember_item_image">
                                    $Image.FocusFill(400,400)
                                </div>
                                <p class="teammember_item_name">$Title</p>
                                <p class="teammember_item_profession">$Profession</p>
                            </div>
                        <% end_if %>
                        <div class="social_icons">
                            <% loop $Socials %>
                                <% include SocialIcon %>
                            <% end_loop %>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
    </div>
</div>

$ElementalArea
