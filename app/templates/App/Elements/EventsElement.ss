<div class="section section--EventsElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2 class="section_title">$Title</h2>
        <% end_if %>
        <div class="section_description">
            $Content
        </div>

        <div class="events_list">
            <% loop $Events %>
                <% include EventCard %>
            <% end_loop %>
        </div>
    </div>
</div>
