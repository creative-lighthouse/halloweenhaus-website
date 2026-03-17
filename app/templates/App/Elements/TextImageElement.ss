<section class="section--TextImageElement $Variant">
    <div class="section_content grid-layout">
        <% if $VideoCode %>
            <div class="section_video">
                <a class="media" href="https://www.youtube.com/watch?v=$VideoCode" target="_blank" rel="noopener noreferrer">
                    $Thumbnail
                </a>
            </div>
        <% else_if $Image %>
             <div class="section_image">
                $Image.FocusFillMax(600, 400)
            </div>
        <% end_if %>

        <div class="section_text">
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

            <% if $Button %>
                <div class="section_button">
                    <% include Button Button=$Button %>
                </div>
            <% end_if %>
        </div>
    </div>
</section>
