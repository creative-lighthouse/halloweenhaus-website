<% with $TeamMember %>
    <div class="section section--TeamDetails">
        <div class="section_content">
            <a class="white no_deco back" href="$Top.Link">Zurück zur Übersicht</a>
            <div class="teammember_item_image">
                $Image.FocusFill(600,600)
            </div>
            <h1 class="teammember_name">$Title</h1>
            <p class="teammember_profession">$Profession</p>
            <p class="teammember_time">$Jointime</p>

            <div class="teammember_description">
                $Description
            </div>

            <div class="teammember_gallery">
                <% loop PhotoGalleryImages %>
                    <div class="item_gallery_image">
                        <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" href="$Image.FitMax(2000,2000).URL"><img src="$Image.FocusFill(150,150).URL" /></a>
                    </div>
                <% end_loop %>
            </div>

            <div class="social_icons">
                <% loop $Socials %>
                    <% include SocialIcon %>
                <% end_loop %>
            </div>
        </div>

    </div>
<% end_with %>
