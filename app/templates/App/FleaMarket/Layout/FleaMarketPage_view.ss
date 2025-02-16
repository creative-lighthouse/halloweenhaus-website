<% with $Product %>
    <div class="section section--fleamarket">
        <div class="section_content">
            <div class="experiencegallery swiper">
                <div class="experiencegallery_slider swiper-wrapper">
                    <% loop PhotoGalleryImages %>
                        <div class="swiper-slide">
                            <a data-gallery="gallery" data-glightbox="description: $Title" data-caption="$Title" class="experienceimage" data-noloadingscreen="true" href="$Image.URL">
                                $Image.FocusFill(1000,400)
                            </a>
                        </div>
                    <% end_loop %>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <h1>$Title</h1>
            <p>Code: #$ProductCode</p>
            <p>Preis: $FormattedPrice</p>
            <p>Kategorien: $CategoriesList</p>
            <hr>
            $Description
        </div>
    </div>
<% end_with %>
