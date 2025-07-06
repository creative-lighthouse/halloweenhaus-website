<div class="section section--FAQElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <div class="section_title">
                <h2>$Title</h2>
            </div>
        <% end_if %>
        <div class="section_list">
            <% loop $FAQItems %>
                <div class="list_item <% if Up.IsCollapsible %><% else %>list_item--visible<% end_if %>">
                    <div class="list_item_content">
                        <% if Up.IsCollapsible %>
                            <a class="list_item_content_date no_deco" href="" data-behaviour="list-toggle">
                            <h4>$Year</h4>
                            </a>
                            <a class="list_item_content_title no_deco" href="" data-behaviour="list-toggle">
                                <div class="list_item_title_triangle" data-behaviour="list-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg"><path d="M12 15.5l-6.5-6.5 1.5-1.5 5 5 5-5 1.5 1.5z"></path></svg>
                                </div>
                                <h3>$Title</h3>
                            </a>
                            <div class="list_item_content_text">
                                $Text
                                <div class="faq_gallery">
                                    <% loop PhotoGalleryImages %>
                                        <div class="item_gallery_image">
                                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" href="$Image.FitMax(2000,2000).URL"><img src="$Image.FocusFill(150,150).URL" /></a>
                                        </div>
                                    <% end_loop %>
                                </div>
                            </div>
                        <% else %>
                            <div class="list_item_content_date" href="">
                                <h4>$Year</h4>
                            </div>
                            <div class="list_item_content_title">
                                <h3>$Title</h3>
                            </div>
                            <div class="list_item_content_text">
                                $Text
                                <div class="faq_gallery">
                                    <% loop PhotoGalleryImages %>
                                        <div class="item_gallery_image">
                                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" href="$Image.FitMax(2000,2000).URL"><img src="$Image.FocusFill(150,150).URL" /></a>
                                        </div>
                                    <% end_loop %>
                                </div>
                            </div>
                        <% end_if %>
                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
