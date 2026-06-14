<section class="section--ImageBannerElement $Variant $Overlay" <% if $Variant!="variant--autoheight" && $Height != 0 %>style="height: {$Height}px"<% end_if %> >
    <% if $Parallax != 0 %>
        <% if $Variant == "variant--contained" %>
            <div class="section_content">
                <img src="$Image.FocusFill(2000, 700).Link" alt="$Image.Title" />
            </div>
        <% else %>
            <div class="section_content" data-behaviour="parallax" data-speed="$Parallax" style="background-image:url($Image.FocusFill(2000, 1000).Link)">

            </div>
        <% end_if %>
    <% else %>
        <% if $Variant == "variant--contained" %>
            <div class="section_content">
                <img src="$Image.FocusFill(2000, 700).Link" alt="$Image.Title" />
            </div>
        <% else_if $Variant == "variant--autoheight" %>
            <div class="section_content" style="height: auto;">
                <img src="$Image.Link" alt="$Image.Title" style="width: 100%; height: auto;" />
            </div>
        <% else %>
            <div class="section_content" style="background-image:url($Image.FocusFill(2000, 700).Link); height: 100%;">
            </div>
        <% end_if %>
    <% end_if %>
    <div class="section_description">
            <p>$Text</p>
    </div>
</section>
