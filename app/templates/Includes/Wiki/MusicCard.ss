<a href="$Link" class="musiccard" style="view-transition-name: musiccard-$ID;">
    <div class="musiccard_image" style="view-transition-name: musicimage-$ID;">
        IN ARBEIT
        <% if $Image %>
            $Image.FocusFill(500,300)
        <% else %>
            <img src="_resources/app/client/images/placeholder-image.jpg" alt="Kein Bild verfügbar" style="width: 100%; height: 100%; object-fit: cover;">
        <% end_if %>
    </div>
    <div class="musiccard_content">
        <h3 class="musiccard_name">$Title</h3>
        <% if $ShortDescription %><p class="musiccard_shortdescription">$ShortDescription</p><% end_if %>
        <% if $PublicationDate %><p class="musiccard_publicationdate"><b>Veröffentlicht am:</b> $RenderPublicationDate</p><% end_if %>
    </div>
</a>
