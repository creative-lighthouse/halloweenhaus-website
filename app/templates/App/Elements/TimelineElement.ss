<div class="section section--TimelineElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <div class="section_title">
                <h2>$Title</h2>
            </div>
        <% end_if %>
        <div class="section_list_filter">
            <a class="filter_item" data-behaviour="timelineFilter" data-type="halloween">Halloween</a>
            <a class="filter_item" data-behaviour="timelineFilter" data-type="media">Medien</a>
            <a class="filter_item" data-behaviour="timelineFilter" data-type="milestone">Meilensteine</a>
            <a class="filter_item" data-behaviour="timelineFilter" data-type="other">Anderes</a>
        </div>
        <div class="section_list">
            <% loop $TimelineItems %>
                <div class="list_item active <% if Up.IsCollapsible %><% else %>list_item--visible<% end_if %>" data-behaviour="timelineItem" data-type="$Type" data-collapsible="true">
                    <div class="list_item_timeline timeline_toggle">
                        <span class="circle"></span>
                        <span class="line"></span>
                    </div>
                    <div class="list_item_content">
                        <% if Up.IsCollapsible %>
                            <p class="list_item_content_date no_deco timeline_toggle">$Year <% if $Type %>- $getFormattedType($Type)<% end_if %></p>
                            <h3 class="list_item_content_title no_deco timeline_toggle">$Headline</h3>
                            <div class="list_item_content_text">
                                $Text
                                <div class="timeline_gallery">
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
                                <h3>$Headline</h3>
                            </div>
                            <div class="list_item_content_text">
                                $Text
                                <div class="timeline_gallery">
                                    <% loop PhotoGalleryImages %>
                                        <div class="item_gallery_image">
                                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" href="$Image.FitMax(2000,2000).URL"><img src="$Image.FocusFill(150,150).URL" /></a>
                                        </div>
                                    <% end_loop %>
                                </div>
                            </div>
                        <% end_if %>
                    </div>
                    <div class="list_item_arrow timeline_toggle">
                        <% if Up.IsCollapsible %>
                            <div class="arrow"></div>
                        <% end_if %>
                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
