<section class="section section--imagebanner $Variant $Overlay" style="height: {$Height}px" >
    <% if $Parallax != 0 %>
        <div class="section_content" data-behaviour="parallax" data-speed="$Parallax" style="background-image:url($Image.FocusFill(2000, 1000).Link)">

        </div>
    <% else %>
        <div class="section_content" style="background-image:url($Image.FocusFill(2000, 700).Link); height: 100%;">

        </div>
    <% end_if %>
    <div class="section_description">
            <p>$Text</p>
    </div>
</section>
