<section class="section--HeroSlider">
    <div class="section_content">
        <div class="swiper--hero">
            <div class="swiper-wrapper">
                <% if $UseRandomOrder %>
                    <% loop $SlidesInRandomOrder %>
                        <div class="swiper-slide">
                            <img src="$Image.FocusFill(1500,700).URL" alt="$Title" class="hero_image">
                        </div>
                    <% end_loop %>
                <% else %>
                    <% loop $HeroSliderItems %>
                        <div class="swiper-slide">
                            <img src="$Image.FocusFill(1500,700).URL" alt="$Title" class="hero_image">
                        </div>
                    <% end_loop %>
                <% end_if %>
            </div>
        </div>
        <% if $DateFrameTitle || $DateFrameText || $DateFrameSubText %>
            <div class="hero_dateframe">
                <img src="../_resources/app/client/images/DekoFrame.svg" alt="Date Frame Background" class="dateframe_background">
                <div class="dateframe_text_wrap">
                    <h2 class="dateframe_title">$DateFrameTitle</h2>
                    <p class="dateframe_text">$DateFrameText</p>
                    <p class="dateframe_subtext">$DateFrameSubText</p>
                </div>
            </div>
        <% end_if %>
    </div>
</section>
