<% with $Product %>
    <div class="section section--fleamarket">
        <div class="section_content">
            <a class="backbutton" href="$Top.Link">← Zurück zur Übersicht</a>
            <h1>Flohmarkt</h1>
            <div class="productgallery swiper">
                <div class="productgallery_slider swiper-wrapper">
                    <% loop PhotoGalleryImages %>
                        <div class="swiper-slide">
                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" class="productimage" data-noloadingscreen="true" href="$Image.URL">
                                $Image.FocusFill(1200,500)
                            </a>
                        </div>
                    <% end_loop %>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <h1>$Title</h1>
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
            </table>
            $Description
        </div>
    </div>
<% end_with %>
