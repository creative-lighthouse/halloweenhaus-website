<div class="header">
    <div class="header_nav">
        <a href="" class="nav_brand">
            <% include MovingLogo %>
        </a>
        <div class="menus">
            <div class="place">
                <p>$SiteConfig.DateText</p>
                <p>$SiteConfig.PlaceText</p>
            </div>
            <div class="nav_mainmenu">
                <a href="faq" class="nav_link faq">FAQ</a>
                <a href="termine" class="link--button hollow nav_link virtualqueue">Termin buchen</a>
            </div>
            <div class="nav_secondarymenu">
                <% loop $Menu(1) %>
                <% if $MenuPosition != "footer" %>
                <a href="$Link" class="nav_link<% if $LinkOrSection == "section" %> nav_link--active<% end_if %>">$MenuTitle</a>
                <% end_if %>
                <% end_loop %>
            </div>
            <div class="nav_button" data-behaviour="toggle-menu">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
            </div>
        </div>
    </div>
</div>

<% if $SiteConfig.ShowBanner %>
    <div class="banner">
        $SiteConfig.BannerText
    </div>
<% end_if %>
