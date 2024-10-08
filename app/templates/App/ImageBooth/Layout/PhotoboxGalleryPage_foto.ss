<% with $BoothImage %>
    <div class="section section--PhotoboxImage">
        <h1>Foto Nr. $ID</h1>
        <h3>$FormattedCreationDate</h3>
        <div class="photobox_image">
            <img src="$Base64Image" alt="$Created" />
        </div>
        <a download href="$Base64Image" target="_blank" class="photobox_download">Download</a>
    </div>
<% end_with %>
