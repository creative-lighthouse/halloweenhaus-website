<div class="section section--TeamOverview">
    <div class="section_content">
        <h1 class="teammember_title">$Title</h1>
        <% cached 'team_overview', $TeamMembersCacheKey %>
        <% if $TeamMembers.Filter("Status", "active").Count > 0 %>
            <div class="teammember_list">
                <% loop $TeamMembers.Sort("Importance", DESC).Filter("Status", "active") %>
                    <div class="teammember_item">
                        <a class="teammember_texts no_deco" href="$Top.Link('view')/$ID-$FormattedName">
                            <div class="teammember_item_image">
                                $Image.FocusFill(400,400)
                            </div>
                            <p class="teammember_item_name">$Title</p>
                            <p class="teammember_item_profession">$Profession</p>
                        </a>
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
                        <div class="teammember_texts no_deco">
                            <div class="teammember_item_image">
                                $Image.FocusFill(400,400)
                            </div>
                            <p class="teammember_item_name">$Title</p>
                            <p class="teammember_item_profession">$Profession</p>
                        </div>
                        <div class="social_icons">
                            <% loop $Socials %>
                                <% include SocialIcon %>
                            <% end_loop %>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
        <% end_cached %>
    </div>
</div>

$ElementalArea
