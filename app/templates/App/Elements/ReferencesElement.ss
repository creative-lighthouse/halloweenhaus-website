<section class="section--ReferencesElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <% if $Text %>
            <p>$Text</p>
        <% end_if %>
        <% loop $ReferencesByYear %>
            <div class="references_year_group">
                <h3 class="references_year_heading">$Year</h3>
                <div class="referenceelement_list">
                    <% loop $References %>
                        <% if $SourceLink.Url %>
                            <a href="$SourceLink.Url" <% if $SourceLink.OpenInNew %> target="_blank"<% end_if %> class="referenceitem no_deco">
                                <% if $Text %>
                                    <div class="referenceitem_text">$Text</div>
                                <% end_if %>
                                <p class="referenceitem_source">$Title</p>
                            </a>
                        <% else %>
                            <div class="referenceitem no_color">
                                <% if $Text %>
                                    <div class="referenceitem_text">$Text</div>
                                <% end_if %>
                                <p class="referenceitem_source">$Title</p>
                            </div>
                        <% end_if %>
                    <% end_loop %>
                </div>
            </div>
        <% end_loop %>
    </div>
</section>
