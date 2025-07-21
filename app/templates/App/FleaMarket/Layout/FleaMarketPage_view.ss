<% with $Product %>
    <div class="section section--fleamarket">
        <div class="section_content">
            <a class="backbutton" href="$Top.Link">Zurück zur Übersicht</a>
            <h1>Flohmarkt</h1>
            <div class="productgallery swiper">
                <div class="productgallery_slider swiper-wrapper">
                    <% loop PhotoGalleryImages %>
                        <div class="swiper-slide">
                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" class="productimage" data-noloadingscreen="true" href="$Image.URL">
                                $Image.FitMax(1200,900)
                                <img src="$Image.FillMax(400,300).URL" alt="$Title" class="product_image_background"/>
                            </a>
                        </div>
                    <% end_loop %>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <h1>$Title</h1>
            $Description
            <table class="productinfo">
                <tr>
                    <td>Code:</td>
                    <td>#$ProductCode</td>
                </tr>
                <tr>
                    <td>Preis:</td>
                    <td>$FormattedPrice <% if $NegotiablePrice %>(auf Verhandlungsbasis)<% end_if %></td>
                </tr>
                <tr>
                    <td>Kategorien:</td>
                    <td>$CategoriesList</td>
                </tr>
                <% if $Size %>
                    <tr>
                        <td>Größe:</td>
                        <td>$Size</td>
                    </tr>
                <% end_if %>
                <% if $Material %>
                    <tr>
                        <td>Material:</td>
                        <td>$Material</td>
                    </tr>
                <% end_if %>
                <% if $Color %>
                    <tr>
                        <td>Farbe:</td>
                        <td>$Color</td>
                    </tr>
                <% end_if %>
                <% if $Brand %>
                    <tr>
                        <td>Marke:</td>
                        <td>$Brand</td>
                    </tr>
                <% end_if %>
                <% if $Model %>
                    <tr>
                        <td>Modell:</td>
                        <td>$Model</td>
                    </tr>
                <% end_if %>
                <% if $Condition %>
                    <tr>
                        <td>Zustand:</td>
                        <td>$Condition</td>
                    </tr>
                <% end_if %>
                <% if $Weight %>
                    <tr>
                        <td>Gewicht:</td>
                        <td>$Weight</td>
                    </tr>
                <% end_if %>
            </table>
        </div>
    </div>
<% end_with %>
