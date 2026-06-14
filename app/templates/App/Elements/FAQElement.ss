<section class="section--FAQElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <div class="section_title">
                <h2>$Title</h2>
            </div>
        <% end_if %>
        <div class="section_list">
            <% loop $FAQItems %>
                <div class="list_item">
                    <% if Up.IsCollapsible %>
                        <details>
                            <summary class="list_item_content_title no_deco">
                                <div class="list_item_title_triangle">
                                    <svg xmlns="http://www.w3.org/2000/svg"><path d="M12 15.5l-6.5-6.5 1.5-1.5 5 5 5-5 1.5 1.5z"></path></svg>
                                </div>
                                <h3 class="list_item_title">$Title</h3>
                            </summary>
                            <div class="list_item_content_text">
                                $Text
                                <div class="faq_gallery">
                                    <% loop PhotoGalleryImages %>
                                        <div class="item_gallery_image">
                                            <a href="$Image.AbsoluteURL" data-gallery="gallery" data-galleryid="FAQElement-$Up.ID" data-glightbox="$Title" data-caption="$Title" class="section_image_lightbox">
                                                $Image.FocusFill(150,150)
                                            </a>
                                        </div>
                                    <% end_loop %>
                                </div>
                            </div>
                        </details>
                    <% else %>
                        <div class="list_item_content_title">
                            <h3>$Title</h3>
                        </div>
                        <div class="list_item_content_text">
                            $Text
                            <div class="faq_gallery">
                                <% loop PhotoGalleryImages %>
                                    <div class="item_gallery_image">
                                        <a href="$Image.AbsoluteURL" data-gallery="gallery" data-galleryid="FAQElement-$Up.ID" data-glightbox="$Title" data-caption="$Title" class="section_image_lightbox">
                                            $Image.FocusFill(150,150)
                                        </a>
                                    </div>
                                <% end_loop %>
                            </div>
                        </div>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
    </div>
</section>
