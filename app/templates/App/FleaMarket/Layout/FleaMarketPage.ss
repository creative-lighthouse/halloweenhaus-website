<div class="section section--fleamarket">
    <div class="section_content">
        <a class="backbutton"></a>
        <h1>Flohmarkt</h1>
        $Text
        <div class="fleamarket_categories">
            <p><b>Kategorien:</b></p>
            <% loop $Categories %>
                <% if $Products.Count > 0 %>
                    <a href="$Link" class="fleamarket_category">
                        $Title
                    </a>
                <% end_if %>
            <% end_loop %>
        </div>
        <div class="fleamarket_items">
            <% loop $Products %>
                <a href="$Link" class="fleamarket_item">
                    <div class="fleamarket_item_image">
                        <% if $Image %>
                            $Image.FocusFill(300,300)
                        <% else %>
                            <img src="../_resources/app/client/images/placeholder-image.jpg" alt="Placeholder image">
                        <% end_if %>
                        <p class="fleamarket_item_code">#$ProductCode</p>
                    </div>
                    <div class="fleamarket_item_text">
                        <h2>$Title</h2>
                        <p>$FormattedPrice <% if $NegotiablePrice %>VB<% end_if %></p>
                    </div>
                </a>
            <% end_loop %>
        </div>
    </div>
</div>
