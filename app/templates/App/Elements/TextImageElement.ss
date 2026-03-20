<section class="section--TextImageElement $Variant">
    <div class="section_content grid-layout">
        <% if $Embed %>
            <div class="section_embed">
                $Embed.Raw
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
