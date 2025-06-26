<% if not $OnlyNearHalloween || $NearHalloween %>
<div class="section section--text $AlignVariant $ColorVariant">
    <div class="section_content">
        <% if ShowTitle %>
            <h2 class="text_title">$Title</h2>
        <% end_if %>
        <div class="text_content">
            $Text
            <div class="text_button">
            <% include Button Button=$Button %>
        </div>
        </div>
    </div>
</div>
<% end_if %>
