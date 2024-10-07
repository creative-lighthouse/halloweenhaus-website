<div class="section section--PhotoboxGallery">
    <h1>$Title</h1>
    <div class="photobox_gallery">
        <% loop $BoothImages %>
            <div class="photobox_image">
                <div class="photobox_image_meta">
                    <p>Foto Nr. $ID | $FormattedCreationDate</p>
                    <a download href="$Base64Image" target="_blank" class="photobox_download">Download</a>
                </div>
                <div class="photobox_image_content">
                    <img src="$Base64Image" alt="$Created" />
                </div>
            </div>
        <% end_loop %>
    </div>
</div>
