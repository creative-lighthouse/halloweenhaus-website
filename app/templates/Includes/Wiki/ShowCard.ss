<a href="$Link" class="swiper-slide showcard" style="view-transition-name: showcard-$ID;">
    <div class="showcard_image" style="view-transition-name: showposter-$ID;">
        <% if $Image %>
            $Image.FocusFill(420,600)
        <% else %>
            <img src="_resources/app/client/images/placeholder-image.jpg" alt="Kein Bild verfügbar" style="width: 100%; height: 100%; object-fit: cover;">
        <% end_if %>
    </div>
    <div class="showcard_content">
        <h2 class="showcard_dates" style="view-transition-name: showyear-$ID;">$Year</h2>
        <h3 class="showcard_title" style="view-transition-name: showtitle-$ID;">$Title</h3>
    </div>
</a>
