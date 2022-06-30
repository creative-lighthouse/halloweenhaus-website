<div class="section section--textimage $Highlight $Variant $ImgWidth">
    <% if $Image %>
        <div class="textimage_image">
            <% if $ImageIsLinked %>
                <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %>>
                    $Image.ScaleWidth(800)
                </a>
            <% else %>
                $Image.ScaleWidth(800)
            <% end_if %>
        </div>
    <% end_if %>

    <div class="textimage_text">
        <div class="textimage_text_content">
            <% if $ShowTitle %>
                <h2 class="textimage_text_title">$Title</h2>
            <% end_if %>
            $Text
            <% if $Button %>
                <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow textimage_text_button no_deco readmore">$Button.Title</a>
            <% end_if %>
        </div>
    </div>
</div>
