<section class="section--WikiPage showoverview--itemdetails">
    <% with $Character %>
        <div class="section_content">
            <a class="backbutton" href="$Top.Link">&larr; Zurück zur Übersicht</a>
            <div class="showsection showsection--details" style="view-transition-name: charactercard-$ID;">
                <% if $Image %>
                    <a href="$Image.Url" data-gallery="gallery" data-galleryid="character" class="character_image" style="view-transition-name: characterimage-$ID;">
                        $Image.FocusFill(300,500)
                    </a>
                <% else %>
                    <br>
                <% end_if %>
                <h1 class="character_title">$Title</h1>
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
            <% if $Jointime || $Bodysize || $Bodyweight || $Age %>
                <div class="showsection showsection--numbers">
                    <h2>Daten & Fakten</h2>
                    <div class="section_text">
                        <% if $Jointime %>
                            <p><b>Erstmals genannt:</b> $Jointime</p>
                        <% end_if %>
                        <% if $Age %>
                            <p><b>Alter:</b> $Age</p>
                        <% end_if %>
                        <% if $Bodysize %>
                            <p><b>Körpergröße:</b> $Bodysize</p>
                        <% end_if %>
                        <% if $Bodyweight %>
                            <p><b>Körpergewicht:</b> $Bodyweight</p>
                        <% end_if %>
                    </div>
                </div>
            <% end_if %>
            <% if $GroupedShowCharacters.Count > 0 %>
                <div class="showsection showsection--shows">
                    <h2>Vorkomnisse in Shows</h2>
                    <div class="showswiper swiper--showsoverview">
                        <div class="swiper-wrapper">
                            <% loop $GroupedShowCharacters.GroupedBy('ParentID') %>
                                <a href="$Children.First.Parent.Link" class="swiper-slide showcard">
                                    <div class="showcard_image">
                                        $Children.First.Parent.PosterImage.Fill(420,600)
                                    </div>
                                    <div class="showcard_content">
                                        <h2 class="showcard_dates">$Children.First.Parent.Year</h2>
                                        <h3 class="showcard_title">$Children.First.Parent.Title</h3>
                                    </div>
                                    <% if $Children.Count > 0 %>
                                        <p class="character_actorlist_title">Gespielt von:</p>
                                        <div class="character_actorlist">
                                            <div class="character_actor">
                                                <% loop $Children %>
                                                    $TeamMember.Image
                                                    <p>$TeamMember.Title</p>
                                                <% end_loop %>
                                            </div>
                                        </div>
                                    <% end_if %>
                                </a>
                            <% end_loop %>
                        </div>
                    </div>
                </div>
            <% end_if %>
            <% if $GroupedArtefactOwnerships.Count > 0 %>
                <div class="showsection showsection--artefacts">
                    <h2>Wichtige Artefakte & Gegenstände des Charakters</h2>
                    <div class="artefactgrid">
                        <% loop $GroupedArtefactOwnerships.GroupedBy('ParentID') %>
                            <a href="$Children.First.Parent.Link" class="artefactcard">
                                <div class="artefactcard_image">
                                    $Children.First.Parent.Image.FocusFill(200,200)
                                </div>
                                <div class="artefactcard_content">
                                    <h3 class="artefactcard_name">$Children.First.Parent.Title</h3>
                                    <% if $Children.First.Parent.ShortDescription %><p class="artefactcard_shortdescription">$Children.First.Parent.ShortDescription</p><% end_if %>
                                    <% if $Children.First.Parent.Jointime %><p class="artefactcard_jointime"><b>Erstmals genannt:</b> $Children.First.Parent.Jointime</p><% end_if %>
                                    <p class="artefact_ownershiplisttitle">Besitz:</p>
                                    <div class="artefact_ownershiplist">
                                        <% loop $Children %>
                                            <p class="artefact_ownershipentry"><b>$Character.Title</b>:<br> $RenderOwnershipTimespan</p>
                                        <% end_loop %>
                                    </div>
                                </div>
                            </a>
                        <% end_loop %>
                    </div>
                </div>
            <% end_if %>
        </div>
    <% end_with %>
</section>
