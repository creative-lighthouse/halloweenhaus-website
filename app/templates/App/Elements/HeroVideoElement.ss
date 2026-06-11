<section class="section--HeroVideoElement">
    <div class="section_content" <% if $ImageBackground %>style="background-image:url($ImageBackground.FocusFill(2500, 1090).Link);"<% end_if %>>
        <% if $DirectVideo %>
            <video src="$DirectVideo" autoplay muted loop playsinline class="hero_video"></video>
        <% else %>
            $EmbedCode.Raw
        <% end_if %>
        <% if $DateFrameTitle || $DateFrameText || $DateFrameSubText %>
            <div class="hero_dateframe">
                <img src="../_resources/app/client/images/DekoFrame.svg" alt="Date Frame Background" class="dateframe_background">
                <h1 class="dateframe_title">$DateFrameTitle</h1>
                <p class="dateframe_text">$DateFrameText</p>
                <p class="dateframe_subtext">$DateFrameSubText</p>
            </div>
        <% end_if %>
    </div>
</section>
