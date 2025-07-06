<section class="section section--PressImagesElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="press_images">
            <% loop $PressImages %>
                <div class="pressimage_entry">
                    <div class="pressimage">
                        <div class="pressimage_image">
                            <a class="pressimage_image_content" href="$Image.AbsoluteUrl" target="_blank">
                                <img data-gallery="gallery" data-glightbox="$Title" data-caption="$Title" src="$Image.URL" alt="$Image.Title" />
                            </a>
                        </div>
                        <div class="pressimage_meta">
                            <h3>$Title</h3>
                            <% if $Description %>
                                <p>$Description</p>
                            <% end_if %>
                            <% if $Copyright %>
                                <p><b>Urheber:</b></p>
                                <p>$Copyright</p>
                            <% end_if %>
                            <% if $FileExtension %>
                                <p><b>Format:</b></p>
                                <p>.{$FileExtension}</p>
                            <% end_if %>
                            <% if $FileSize %>
                                <p><b>Größe:</b></p>
                                <p>$FileSize</p>
                            <% end_if %>
                            <% if $Image %>
                                <p><b>Auflösung:</b></p>
                                <p>{$Image.Width} x {$Image.Height}px</p>
                            <% end_if %>
                            <a href="$Image.AbsoluteUrl" download="$Title" target="_blank" class="pressimage_download">Download</a>
                        </div>

                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
</section>
