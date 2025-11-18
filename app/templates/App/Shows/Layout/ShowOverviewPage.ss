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
                        <a href="$Top.Link/show/$ID" class="swiper-slide showcard">
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
                    <a href="$Top.Link/character/$ID" class="charactercard">
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
    </div>
</section>
