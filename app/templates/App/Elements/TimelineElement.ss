<div class="section section--timeline">
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
            <div class="list_item active <% if Up.IsCollapsible %><% else %>list_item--visible<% end_if %>" data-behaviour="timelineItem" data-type="$Type">
                    <div class="list_item_timeline">
                        <span class="circle"></span>
                        <span class="line"></span>
                    </div>
                    <div class="list_item_content">
                        <% if Up.IsCollapsible %>
                            <a class="list_item_content_date no_deco" href="" data-behaviour="list-toggle">
                            <p>$Year <% if $Type %>- $getFormattedType($Type)<% end_if %></p>
                            </a>
                            <a class="list_item_content_title no_deco" href="" data-behaviour="list-toggle">
                                <h3>$Headline</h3>
                            </a>
                            <div class="list_item_content_text">
                                $Text
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
                            </div>
                        <% end_if %>
                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
