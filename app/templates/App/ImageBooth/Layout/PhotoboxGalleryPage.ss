<div class="section section--PhotoboxGallery">
    <h1>$Title</h1>
    <div class="photobox_gallery">
        <% loop $BoothImages %>
            <div class="photobox_image">
                <div class="photobox_image_meta">
                    <p>Foto $HashID | $FormattedCreationDate</p>
                    <a download href="$Image.Url" target="_blank" class="photobox_download">Download</a>
                </div>
                <a class="photobox_image_content" href="$Top.Link('/foto')/$HashID">
                    $Image.Fill(400, 400)
                </a>
            </div>
        <% end_loop %>
    </div>
</div>
