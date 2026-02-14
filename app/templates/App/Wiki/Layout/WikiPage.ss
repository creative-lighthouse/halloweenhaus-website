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
                            <% include Includes/Wiki/ShowCard %>
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
                        <% include Includes/Wiki/CharacterCard %>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
        <% if $Locations.Count > 0 %>
        <div class="showsection showsection--locations">
            <h2>Orte</h2>
            <div class="locationsgrid">
                <% loop $Locations %>
                    <% include Includes/Wiki/LocationCard %>
                <% end_loop %>
            </div>
        </div>
        <% end_if %>
        <% if $Artefacts.Count > 0 %>
            <div class="showsection showsection--artefacts">
                <h2>Wichtige Artefakte & Gegenstände</h2>
                <div class="artefactgrid">
                    <% loop $Artefacts %>
                        <% include Includes/Wiki/ArtefactCard %>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
        <% if $MediaProjects.Count > 0 %>
            <div class="showsection showsection--mediaprojects">
                <h2>Filme & Medienprojekte</h2>
                <div class="mediaprojectgrid">
                    <% loop $MediaProjects %>
                        <% include Includes/Wiki/MediaprojectCard %>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
    </div>
</section>
