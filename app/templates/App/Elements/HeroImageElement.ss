<section class="section section--heroimage">
<div class="section_content" <% if $ImageBackground %>style="background-image:url($ImageBackground.FocusFill(2500, 1090).Link);"<% end_if %>>
        <% if $ImageBackground2 %>
            <img class="heroimage_image background2" src="$ImageBackground2.FocusFill(2500, 1090).Link">
        <% end_if %>
        <% if $ImageCharacter %>
            <img class="heroimage_image character" src="$ImageCharacter.FocusFill(2500, 1090).Link">
        <% end_if %>
        <div class="heroimage_object">
            <% if $ImageObject %>
                <img class="heroimage_image object" src="$ImageObject.FocusFill(2500, 1090).Link">
            <% end_if %>
            <% if $ImageEffect %>
                <img class="heroimage_image effect" src="$ImageEffect.FocusFill(2500, 1090).Link">
            <% end_if %>
            <% if $ImageEffectOverlay %>
                <img class="heroimage_image effectoverlay" src="$ImageEffectOverlay.FocusFill(2500, 1090).Link">
            <% end_if %>
        </div>
    </div>
</section>
