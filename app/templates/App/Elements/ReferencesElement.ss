<div class="section section--ReferencesElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="referenceelement_list">
            <% loop $ReferenceItems %>
                <% if $Button.Url %>
                    <a href="$Button.Url" <% if $Button.OpenInNew %> target="_blank"<% end_if %> class="referenceitem no_deco">
                        <% if $Text %>
                            <div class="referenceitem_text">
                                $Text
                            </div>
                        <% end_if %>

                        <% if $Button && $Title %>
                            <p class="referenceitem_source">$Title</p>
                        <% else_if $Title %>
                            <p class="referenceitem_source">$Title</p>
                        <% end_if %>
                    </a>
                <% else %>
                    <div class="referenceitem no_deco  no_color">
                        <% if $Text %>
                            <div class="referenceitem_text">
                                $Text
                            </div>
                        <% end_if %>

                        <% if $Button && $Title %>
                            <p class="referenceitem_source">$Title</p>
                        <% else_if $Title %>
                            <p class="referenceitem_source">$Title</p>
                        <% end_if %>
                    </div>
                <% end_if %>
            <% end_loop %>
        </div>
    </div>
</div>
