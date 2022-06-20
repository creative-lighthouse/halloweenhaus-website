<div class="section section--team_overview">
    <div class="section_content">
        <% if ShowTitle %>
            <h1 class="teammember_title">$Title</h1>
        <% end_if %>
        <div class="teammember_list">
            <% loop $TeamMembers.Sort("Importance", DESC) %>
                <a href="$Top.Link('view')/$ID" class="teammember_item">
                    <div class="teammember_item_image">
                        $Image.FocusFill(400,400)
                    </div>
                    <p class="teammember_item_name">$Title</p>
                    <p class="teammember_item_profession">$Profession</p>
                    <p class="teammember_item_time">$Jointime</p>
                </a>
            <% end_loop %>
        </div>
    </div>
</div>
