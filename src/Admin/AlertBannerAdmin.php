<?php

namespace DNADesign\AlertBanners\Admin;

use DNADesign\AlertBanners\Model\AlertBanner;
use SilverStripe\Admin\ModelAdmin;

class AlertBannerAdmin extends ModelAdmin
{
    private static $managed_models = [
        AlertBanner::class
    ];

    private static $url_segment = 'alert-banners';

    private static $menu_title = 'Alert Banners';

    private static $menu_icon_class = 'font-icon-attention';
}
