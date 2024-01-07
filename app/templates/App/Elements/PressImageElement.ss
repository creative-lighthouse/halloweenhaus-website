<section class="section section--pressimages">
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
                            <a href="$Image.AbsoluteUrl" target="_blank">
                                <img src="$Image.URL" alt="$Image.Title" />
                            </a>
                        </div>
                        <div class="pressimage_meta">
                            <h3>$Title</h3>
                            <p>$Description</p>
                            <p><b>Format:</b></p>
                            <p>.{$FileExtension}</p>
                            <p><b>Größe:</b></p>
                            <p>$FileSize</p>
                            <p><b>Maße:</b></p>
                            <p>{$Image.Width} x {$Image.Height}px</p>
                            <a href="$Image.AbsoluteUrl" download target="_blank" class="pressimage_download">Download</a>
                        </div>

                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
</section>
