<section class="section--VideoElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <div class="section_title">
                <h2 class="underlined">$Title</h2>
            </div>
        <% end_if %>
        <% if $Text %>
            <div class="section_text">
                $Text
            </div>
        <% end_if %>
        <% if $VideoLink %>
            <div class="section_video" style="max-width: $Width;">
                <% include YoutubeVideo VideoLink=$VideoLink %>
            </div>
        <% end_if %>
    </div>
</section>
