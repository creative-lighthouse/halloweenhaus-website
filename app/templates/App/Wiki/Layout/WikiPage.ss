<section class="section--WikiPage">
    <div class="section_content">
        <div class="showsection showsection--shows">
            <% if $Image %>
                <div class="wiki_image">
                        <img src="$Image.Fill(940,300).URL" alt="$Title">
                </div>
            <% end_if %>
            <% if $Title %>
                <h1 class="wiki_title">$Title</h1>
            <% end_if %>
            <% if $Description %>
                <div class="wiki_description glossarizable">
                    $Description
                </div>
            <% end_if %>
        </div>
        <% if $Shows.Count > 0 %>
            <div class="showsection showsection--shows">
                <h2>Shows</h2>
                <div class="showswiper swiper--showsoverview">
                    <div class="swiper-wrapper">
                        <% loop $Shows %>
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
        <% if $Characters.Count > 0 %>
            <div class="showsection showsection--characters">
                <h2>Charaktere</h2>
                <div class="charactersgrid">
                    <% loop $Characters %>
                        <a href="$Link" class="charactercard" style="view-transition-name: charactercard-$ID;">
                            <div class="charactercard_image" style="view-transition-name: characterimage-$ID;">
                                $Image.FocusFill(200,200)
                            </div>
                            <div class="charactercard_content">
                                <h3 class="charactercard_name">$Title</h3>
                                <% if $ShortDescription %><p class="charactercard_shortdescription">$ShortDescription</p><% end_if %>
                                <% if $Jointime %><p class="charactercard_jointime"><b>Erstauftritt:</b> $Jointime</p><% end_if %>
                            </div>
                        </a>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
        <% if $Locations.Count > 0 %>
        <div class="showsection showsection--locations">
            <h2>Orte</h2>
            <div class="locationsgrid">
                <% loop $Locations %>
                    <a href="$Link" class="locationcard" style="view-transition-name: locationcard-$ID;">
                        <div class="locationcard_image">
                            $Image.FocusFill(200,200)
                        </div>
                        <div class="locationcard_content">
                            <h3 class="locationcard_name" style="view-transition-name: locationtitle-$ID;">$Title</h3>
                            <% if $ShortDescription %><p class="locationcard_shortdescription">$ShortDescription</p><% end_if %>
                            <% if $Jointime %><p class="locationcard_jointime"><b>Erstmals genannt:</b> $Jointime</p><% end_if %>
                        </div>
                    </a>
                <% end_loop %>
            </div>
        </div>
        <% end_if %>
        <% if $Artefacts.Count > 0 %>
            <div class="showsection showsection--artefacts">
                <h2>Wichtige Artefakte & Gegenstände</h2>
                <div class="artefactgrid">
                    <% loop $Artefacts %>
                        <a href="$Link" class="artefactcard" style="view-transition-name: artefactcard-$ID;">
                            <div class="artefactcard_image" style="view-transition-name: artefactimage-$ID;">
                                $Image.FocusFill(200,200)
                            </div>
                            <div class="artefactcard_content">
                                <h3 class="artefactcard_name">$Title</h3>
                                <% if $ShortDescription %><p class="artefactcard_shortdescription">$ShortDescription</p><% end_if %>
                                <% if $Jointime %><p class="artefactcard_jointime"><b>Erstmals genannt:</b> $Jointime</p><% end_if %>
                            </div>
                        </a>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
        <% if $MediaProjects.Count > 0 %>
            <div class="showsection showsection--mediaprojects">
                <h2>Filme & Medienprojekte</h2>
                <div class="mediaprojectgrid">
                    <% loop $MediaProjects %>
                        <a href="$Link" class="mediaprojectcard" style="view-transition-name: mediaprojectcard-$ID;">
                            <div class="mediaprojectcard_image" style="view-transition-name: mediaprojectimage-$ID;">
                                $Image.FocusFill(400,300)
                            </div>
                            <div class="mediaprojectcard_content">
                                <h3 class="mediaprojectcard_name">$Title</h3>
                                <% if $ShortDescription %><p class="mediaprojectcard_shortdescription">$ShortDescription</p><% end_if %>
                                <% if $PublicationDate %><p class="mediaprojectcard_publicationdate"><b>Veröffentlicht am:</b> $RenderPublicationDate</p><% end_if %>
                            </div>
                        </a>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
    </div>
</section>
