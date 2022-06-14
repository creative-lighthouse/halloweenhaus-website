<div class="section section--text $AlignVariant $ColorVariant">
    <div class="section_content">
        <% if ShowTitle %>
            <h2 class="text_title">$Title</h2>
        <% end_if %>
        <div class="text_content">
            $Text
            <div class="text_button">
            <% if $Button %>
                <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow textimage_text_button readmore">$Button.Title</a>
            <% end_if %>
        </div>
        </div>
    </div>
</div>
