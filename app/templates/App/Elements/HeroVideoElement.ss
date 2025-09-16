<section class="section section--HeroVideoElement">
    <div class="section_content" <% if $ImageBackground %>style="background-image:url($ImageBackground.FocusFill(2500, 1090).Link);"<% end_if %>>
        <% if $DirectVideo %>
            <video src="$DirectVideo" autoplay muted loop playsinline class="hero_video"></video>
        <% else %>
            $EmbedCode.Raw
        <% end_if %>
        <% if $DateFrame %>
            <div class="hero_dateframe">
                $DateFrame
            </div>
        <% end_if %>
    </div>
</section>
