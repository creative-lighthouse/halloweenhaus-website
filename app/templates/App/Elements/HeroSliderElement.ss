<section class="section--HeroSlider">
    <div class="section_content">
        <div class="swiper--hero">
            <div class="swiper-wrapper">
                <% loop $HeroSliderItems %>
                    <div class="swiper-slide">
                        <img src="$Image.FocusFill(1000,1000).URL" alt="$Title" class="hero_image">
                    </div>
                <% end_loop %>
            </div>
        </div>
        <% if $DateFrame %>
            <div class="hero_dateframe">
                $DateFrame
            </div>
        <% end_if %>
    </div>
</section>
