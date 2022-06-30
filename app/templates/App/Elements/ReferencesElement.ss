<div class="section section--references">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="referenceelement_list">
            <% loop $ReferenceItems %>
                <div class="referenceitem">
                    <% if $Text %>
                        <div class="referenceitem_text">
                            $Text
                        </div>
                    <% end_if %>

                    <% if $Button && $Title %>
                        <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="referenceitem_source no_deco">$Title</a>
                    <% else_if $Title %>
                        <p class="referenceitem_source">$Title</p>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
