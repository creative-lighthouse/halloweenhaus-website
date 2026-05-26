<% if $ElementControllers %>
    <% loop $ElementControllers %>
        <% if $ElementIsHidden %>
            <% if $IsDraftVersion %>
                <section class="ElementalArea-hiddenElementNotice">
                    <div class="section_content StatusMessage StatusMessage--warning">
                        <strong>Hinweis:</strong> Das folgende Element ist derzeit ausgeblendet und wird auf der veröffentlichten Website nicht angezeigt:
                    </div>
                </section>
                $Me
            <% end_if %>
        <% else %>
            $Me
       <% end_if %>
    <% end_loop %>
<% end_if %>
