<div class="section section--SocialBannerElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <div class="socialbanner_list">
            <% loop $Socials %>
                <% include SocialIcon %>
            <% end_loop %>
        </div>
    </div>
</div>
