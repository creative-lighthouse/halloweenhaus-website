<div class="section section--VideoElement">
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
                <iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/{$VideoLink}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        <% end_if %>
    </div>
</div>
