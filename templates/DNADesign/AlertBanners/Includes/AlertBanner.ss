<div class="alertbanner alertbanner--$Modifier" role='alert'>
    <div class="alertbanner__icon">
        &nbsp;
    </div>
    <div class="alertbanner__body">
        <div class="alertbanner__title">
            $Title
        </div>
        <div class="alertbanner__content">
            <% if $Content.RichLinks %>
                $Content.RichLinks
            <% else %>
                $Content
            <% end_if %>
        </div>
    </div>
    <div class="alertbanner__close">
        &nbsp;
    </div>
</div>