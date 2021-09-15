<div class="alertbanners">
    <% loop $AlertBanners %>
        <% if not $HideBanner %>
            <% include DNADesign/AlertBanners/Includes/AlertBanner %>
        <% end_if %>
    <% end_loop %>
</div>