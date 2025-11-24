<section class="section--WikiPage showoverview--itemdetails">
    <% with $MediaProject %>
        <div class="section_content">
            <div class="wiki-navigation">
                <% if $PrevMediaProject %>
                    <a class="link--button button-prev" href="$PrevMediaProject.Link"></a>
                <% else %>
                    <span class="link--button button-prev link--buttondisabled"></span>
                <% end_if %>
                <a class="link--button button-overview" href="$Top.Link">Übersicht</a>
                <% if $NextMediaProject %>
                    <a class="link--button button-next" href="$NextMediaProject.Link"></a>
                <% else %>
                    <span class="link--button button-next link--buttondisabled"></span>
                <% end_if %>
            </div>
            <div class="showsection showsection--details" style="view-transition-name: mediacard-$ID;">
                <% if $Image %>
                    <a href="$Image.Url" data-gallery="gallery" data-galleryid="mainimage" class="media_image" style="view-transition-name: mediaimage-$ID;">
                        $Image.FocusFill(300,300)
                    </a>
                <% else %>
                    <br>
                <% end_if %>
                <h1 class="media_title" style="view-transition-name: mediatitle-$ID;">$Title</h1>
                <div class="media_description">
                    $Description
                </div>
            </div>
            <% if $PhotoGalleryImages.Count > 0 %>
                <div class="showsection showsection--gallery">
                    <h2>Galerie</h2>
                    <div class="imageswiper swiper--showsoverview">
                        <div class="swiper-wrapper">
                            <% loop $PhotoGalleryImages %>
                                <a href="$Image.Url" data-gallery="gallery" data-galleryid="mediagallery" <% if $Up.Images.Count <= 1 %>data-singleimage=true<% end_if %> <% if $Title %>data-description="$Title"<% end_if %> class="swiper-slide imagecard">
                                    $Image.FocusFill(500, 300)
                                </a>
                            <% end_loop %>
                        </div>
                    </div>
                </div>
            <% end_if %>
        </div>
    <% end_with %>
</section>
