<div class="section section--charactercarousel" style="background-image: url($BackgroundImage.Url);">
    <div class="section_content">
        <div class="character_holder" data-behaviour="characterSlider">
            <% loop $Characters %>
                <div class="character_item">
                    <div class="character_image" data-behaviour="parallax" data-speed="0.5">
                        $Image.FocusFill(800,800)
                    </div>
                    <div class="character_text">
                        <h2>$Title</h2>
                        <% if $Place %><p><b>Herkunft:</b> $Place</p><% end_if %>
                        <% if $Bodysize %><p><b>Körpergröße:</b> $Bodysize</p><% end_if %>
                        <% if $Jointime %><p><b>Erster Auftritt:</b> $Jointime</p><% end_if %>
                        <% if $Age %><p><b>Alter:</b> $Age</p><% end_if %>
                        $Description
                        <% if $Button %>
                            <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow no_deco white">$Button.Title</a>
                        <% end_if %>
                        <% if $Button2 %>
                            <a href="$Button2.Url" <% if $Button2.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow no_deco white">$Button2.Title</a>
                        <% end_if %>
                    </div>
                </div>
            <% end_loop %>
        </div>
        <a class="prev" data-behaviour="prevSlide">&#10094;</a>
        <a class="next" data-behaviour="nextSlide">&#10095;</a>
    </div>
</div>
