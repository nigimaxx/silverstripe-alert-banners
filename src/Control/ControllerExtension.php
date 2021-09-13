<?php

namespace DNADesign\AlertBanners\Control;

use DNADesign\AlertBanners\Model\AlertBanner;
use SilverStripe\Core\Extension;

class ControllerExtension extends Extension
{
    public function AlertBanners()
    {
        return AlertBanner::get();
    }
}
