<div class="section section--facts">
    <div class="section_content">
        <% if $ShowTitle %>
            <h2>$Title</h2>
        <% end_if %>
        <p>$Text</p>
        <div class="factselement_list">
            <% loop $FactItems %>
                <div class="factitem no_deco  no_color">
                    <div class="factitem_facts">
                        <p class="factitem_number"><b data-behaviour="countup" data-targetvalue="$Number">$Number</b></p>
                        <p class="factitem_title">$Title</p>
                    </div>
                    <% if $Text %>
                        <div class="factitem_text">
                            $Text
                        </div>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>
