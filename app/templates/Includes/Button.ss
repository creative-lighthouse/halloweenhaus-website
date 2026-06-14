<% with $Button %>
    <% if $exists %>
        <a href="$Url" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %> class="link--button button--$ButtonType">$Title</a>
    <% end_if %>
<% end_with %>
