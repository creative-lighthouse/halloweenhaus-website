<% with $BoothImage %>
    <div class="section section--PhotoboxImage">
        <h1>Foto Nr. $ID</h1>
        <h3>$FormattedCreationDate</h3>
        <div class="photobox_image">
            $Image.Fill(1000, 1000)
        </div>
        <a download href="$Image.Url" target="_blank" class="photobox_download">Download</a>
    </div>
<% end_with %>
