<section class="section section--pressimages">
    <div class="section_content">
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
                        <p>Metadaten: .{$FileExtension} | $FileSize</p>
                        <a download="$Image.AbsoluteUrl" target="_blank" class="link--button">Download</a>
                    </div>

                </div>
            </div>
        <% end_loop %>
    </div>
</section>
