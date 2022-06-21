<div class="section section--teaser">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="teaserelement_list">
            <% loop $TeaserItems %>
                <div class="teaseritem">
                    <% if $Image %>
                        <div class="teaseritem_image">
                            $Image.FocusFill(200,200)
                        </div>
                    <% end_if %>
                    <% if $Title %><h3 class="teaseritem_title">$Title</h3><% end_if %>
                    <% if $Text %>
                        $Text
                    <% end_if %>
                    <% if $Button %>
                        <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="link--button hollow textimage_text_button readmore">$Button.Title</a>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
