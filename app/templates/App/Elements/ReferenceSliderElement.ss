<div class="section section--ReferenceSliderElement">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="referenceelement_list swiper--references swiper--auto">
            <div class="swiper-wrapper">
                <% loop $ReferenceItems %>
                    <% if $SourceLink.Url %>
                        <a href="$SourceLink.Url" <% if $SourceLink.OpenInNew %> target="_blank"<% end_if %> class="referenceitem no_deco swiper-slide">
                            <% if $Text %>
                                <div class="referenceitem_text">
                                    $Text
                                </div>
                            <% end_if %>

                            <% if $Title %>
                                <p class="referenceitem_source">$Title</p>
                            <% end_if %>
                        </a>
                    <% else %>
                        <div class="referenceitem no_deco  no_color swiper-slide">
                            <% if $Text %>
                                <div class="referenceitem_text">
                                    $Text
                                </div>
                            <% end_if %>

                            <% if $Title %>
                                <p class="referenceitem_source">$Title</p>
                            <% end_if %>
                        </div>
                    <% end_if %>
                <% end_loop %>
            </div>
        </div>

        <% if $Button %>
            <div class="section_button">
                <% include Button Button=$Button %>
            </div>
        <% end_if %>
    </div>
</div>
