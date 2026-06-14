<section class="section--WikiElement">
    <div class="section_content">
        <div class="wiki_banner">
            <img src="$BannerImage.FocusFill(1200,400).URL" alt="$Title">
        </div>
        <div class="wiki_grid grid-layout">
            <div class="section_title">
                <h2>$Title</h2>
            </div>
            <div class="wiki_content">
                $Text
            </div>
            <div class="wiki_images wiki_images--left">
                <img src="$Image1.FitMax(600,600).URL" alt="$Title">
                <img src="$Image2.FitMax(600,600).URL" alt="$Title">
            </div>
            <div class="wiki_images wiki_images--right">
                <img src="$Image3.FitMax(600,600).URL" alt="$Title">
                <img src="$Image4.FitMax(600,600).URL" alt="$Title">
            </div>
            <% if $Button %>
                <div class="section_button">
                    <% include Button Button=$Button %>
                </div>
            <% end_if %>
        </div>
    </div>
</section>
