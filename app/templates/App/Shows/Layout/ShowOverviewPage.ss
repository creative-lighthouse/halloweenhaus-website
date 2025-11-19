<section class="section--ShowOverview">
    <div class="section_content">
        <div class="showsection showsection--shows">
            <h1>$Title</h1>
            $Description
        </div>
        <div class="showsection showsection--shows">
            <h2>Shows</h2>
            <div class="showswiper swiper--showsoverview">
                <div class="swiper-wrapper">
                    <% loop $Shows %>
                        <a href="$Link" class="swiper-slide showcard">
                            <div class="showcard_image">
                                $PosterImage.Fill(420,600)
                            </div>
                            <div class="showcard_content">
                                <h2 class="showcard_dates">$Year</h2>
                                <h3 class="showcard_title">$Title</h3>
                            </div>
                        </a>
                    <% end_loop %>
                </div>
            </div>
        </div>
        <div class="showsection showsection--characters">
            <h2>Charaktere</h2>
            <div class="charactersgrid">
                <% loop $Characters %>
                    <a href="$Link" class="charactercard">
                        <div class="charactercard_image">
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
        <div class="showsection showsection--locations">
            <h2>Orte</h2>
            <div class="locationsgrid">
                <% loop $Locations %>
                    <a href="$Link" class="locationcard">
                        <div class="locationcard_image">
                            $Image.FocusFill(200,200)
                        </div>
                        <div class="locationcard_content">
                            <h3 class="locationcard_name">$Title</h3>
                            <% if $ShortDescription %><p class="locationcard_shortdescription">$ShortDescription</p><% end_if %>
                            <% if $Jointime %><p class="locationcard_jointime"><b>Erstmals genannt:</b> $Jointime</p><% end_if %>
                        </div>
                    </a>
                <% end_loop %>
            </div>
        </div>
        <div class="showsection showsection--artefacts">
            <h2>Wichtige Artefakte & Gegenstände</h2>
            <div class="artefactgrid">
                <% loop $Artefacts %>
                    <a href="$Link" class="artefactcard">
                        <div class="artefactcard_image">
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
    </div>
</section>
