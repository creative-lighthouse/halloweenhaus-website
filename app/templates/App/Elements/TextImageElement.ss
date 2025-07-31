<% if not $OnlyNearHalloween || $NearHalloween %>
    <div class="section section--TextImageElement $BackgroundColor">
        <div class="section_content $Variant $ImgWidth">
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
                        <h2 class="textimage_text_title $TitleAlign">$Title</h2>
                    <% end_if %>
                    $Text
                    <% if $Button %>
                        <div class="textimage_button $ButtonAlign">
                            <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow textimage_text_button no_deco readmore">$Button.Title</a>
                        </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>
<% end_if %>
