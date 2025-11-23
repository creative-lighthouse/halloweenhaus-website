<section class="section--WikiPage showoverview--itemdetails">
    <% with $Location %>
        <div class="section_content">
            <div class="wiki-navigation">
                <% if $PrevLocation %>
                    <a class="link--button button-prev" href="$PrevLocation.Link"></a>
                <% else %>
                    <span class="link--button button-prev link--buttondisabled"></span>
                <% end_if %>
                <a class="link--button button-overview" href="$Top.Link">Übersicht</a>
                <% if $NextLocation %>
                    <a class="link--button button-next" href="$NextLocation.Link"></a>
                <% else %>
                    <span class="link--button button-next link--buttondisabled"></span>
                <% end_if %>
            </div>
            <div class="showsection showsection--details" style="view-transition-name: locationcard-$ID;">
                <% if $Image %>
                    <a href="$Image.Url" data-gallery="gallery" data-galleryid="mainimage" class="location_image" style="view-transition-name: locationimage-$ID;">
                        $Image.FocusFill(950,300)
                    </a>
                <% else %>
                    <br>
                <% end_if %>
                <h1 class="character_title" style="view-transition-name: locationtitle-$ID;">$Title</h1>
                <div class="character_description">
                    $Description
                </div>
            </div>
            <% if $PhotoGalleryImages.Count > 0 %>
                <div class="showsection showsection--gallery">
                    <h2>Galerie</h2>
                    <div class="imageswiper swiper--showsoverview">
                        <div class="swiper-wrapper">
                            <% loop $PhotoGalleryImages %>
                                <a href="$Image.Url" data-gallery="gallery" data-galleryid="locationgallery" <% if $Up.Images.Count <= 1 %>data-singleimage=true<% end_if %> <% if $Title %>data-description="$Title"<% end_if %> class="swiper-slide imagecard">
                                    $Image.FocusFill(500, 300)
                                </a>
                            <% end_loop %>
                        </div>
                    </div>
                </div>
            <% end_if %>
            <% if $LocationShows.Count > 0 %>
                <div class="showsection showsection--shows">
                    <h2>Vorkomnisse in Shows</h2>
                    <div class="showswiper swiper--showsoverview">
                        <div class="swiper-wrapper">
                            <% loop $LocationShows %>
                                <a href="$Link" class="swiper-slide showcard" style="view-transition-name: showcard-$ID;">
                                    <div class="showcard_image" style="view-transition-name: showposter-$ID;">
                                        $PosterImage.Fill(420,600)
                                    </div>
                                    <div class="showcard_content">
                                        <h2 class="showcard_dates" style="view-transition-name: showyear-$ID;">$Year</h2>
                                        <h3 class="showcard_title" style="view-transition-name: showtitle-$ID;">$Title</h3>
                                    </div>
                                </a>
                            <% end_loop %>
                        </div>
                    </div>
                </div>
            <% end_if %>
        </div>
    <% end_with %>
</section>
