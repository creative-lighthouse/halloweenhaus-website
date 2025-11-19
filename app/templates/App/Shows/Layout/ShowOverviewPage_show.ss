<section class="section--ShowOverview showoverview--itemdetails">
    <% with $Show %>
        <div class="section_content">
            <a href="" class="backlink" onclick="history.back(); return false;">&larr; Zurück zur Übersicht</a>
            <div class="showsection showsection--details">
                <div class="overviewimage">
                    $ShowImage.FocusFill(1000,300)
                </div>
                <div class="posterimage">
                    $PosterImage.FocusFill(300,450)
                </div>
                <h1 class="show_year">$Year</h1>
                <h2 class="show_title">$Title</h2>
                <div class="show_storyline">$Storyline</div>
            </div>
            <div class="showsection showsection--characters">
                <h2>Charaktere</h2>
                <div class="charactersgrid">
                    $GroupedCharacters.GroupedBy('CharacterID').First.Title <!-- Not working -->
                    <% loop $GroupedCharacters.GroupedBy('CharacterID') %>
                        <a href="$Character.Link" class="charactercard">
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
                        <a href="$Top.Link/location/$ID" class="locationcard">
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
                        <a href="$Top.Link/artefact/$ID" class="artefactcard">
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
    <% end_with %>
</section>
