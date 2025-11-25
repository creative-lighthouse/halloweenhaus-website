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

            <% if $Roles.Count > 0 %>
                <div class="teammember_roles">
                    <h2>Gespielte Rollen</h2>
                    <% loop $Roles %>
                        <div class="teammember_role_item">
                            <a href="$Character.Link" class="teammember_role_character no_deco">
                                <div class="teammember_role_character_image">
                                    $Character.Image.FocusFill(200,200)
                                </div>
                                <p class="teammember_role_character_name">$Character.Title</p>
                            </a>
                            <p class="teammember_role_show">in <a href="$Parent.Link" class="no_deco">$Parent.Title</a></p>
                        </div>
                    <% end_loop %>
                </div>
            <% end_if %>

            <% if $ParticipatedShows.Count > 0 %>
                <div class="teammember_participatedshows">
                    <h2>Andere beteiligte Shows</h2>
                    <div class="showswiper swiper--showsoverview">
                        <div class="swiper-wrapper">
                            <% loop $ParticipatedShows %>
                                <a href="$Link" class="swiper-slide showcard" style="view-transition-name: showcard-$ID;">
                                    <div class="showcard_image" style="view-transition-name: showposter-$ID;">
                                        $PosterImage.FocusFill(420,600)
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

            <div class="social_icons">
                <% loop $Socials %>
                    <% include SocialIcon %>
                <% end_loop %>
            </div>
        </div>

    </div>
<% end_with %>
