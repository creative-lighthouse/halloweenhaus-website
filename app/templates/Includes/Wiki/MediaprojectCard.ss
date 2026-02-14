<a href="$Link" class="mediaprojectcard" style="view-transition-name: mediaprojectcard-$ID;">
    <div class="mediaprojectcard_image" style="view-transition-name: mediaprojectimage-$ID;">
        <% if $Image %>
            $Image.FocusFill(500,300)
        <% else %>
            <img src="_resources/app/client/images/placeholder-image.jpg" alt="Kein Bild verfügbar" style="width: 100%; height: 100%; object-fit: cover;">
        <% end_if %>
    </div>
    <div class="mediaprojectcard_content">
        <h3 class="mediaprojectcard_name">$Title</h3>
        <% if $ShortDescription %><p class="mediaprojectcard_shortdescription">$ShortDescription</p><% end_if %>
        <% if $PublicationDate %><p class="mediaprojectcard_publicationdate"><b>Veröffentlicht am:</b> $RenderPublicationDate</p><% end_if %>
    </div>
</a>
