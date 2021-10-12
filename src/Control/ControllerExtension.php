<?php

namespace DNADesign\AlertBanners\Control;

use DateTime;
use DNADesign\AlertBanners\Model\AlertBanner;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

class ControllerExtension extends Extension
{

    /**
     * Load the required JS file
     */
    public function onAfterInit()
    {
        Requirements::javascript('dnadesign/silverstripe-alert-banners: client/dist/alert-banners.js');
    }

    /**
     * Alert banners to be displayed on the front end
     * @return Datalist
     */
    public function AlertBanners()
    {
        return AlertBanner::get()
            ->filterByCallback(function ($alert) {
                return $this->canDisplay($alert);
            })->sort('SortOrder', 'ASC');
    }

    /**
     * Determines if an alert banner should be displayed on the current page
     * @return boolean
     */
    public function canDisplay($alert)
    {
        $canDisplay = false;
        // first check if the alert banner should be displayed based on the date rules
        if ($alert->DisplayFrom && new DateTime() >= new DateTime($alert->DisplayFrom)) {
            $canDisplay = true;
            if ($alert->DisplayTo && new DateTime() >= new DateTime($alert->DisplayTo)) {
                return false;
            }
        }

        if (empty($alert->DisplayFrom) && empty($alert->DisplayTo)) {
            $canDisplay = true;
        }

        // then check if the current page is affected by any of this alert banners display rules
        if ($canDisplay && $alert->DisplayRules()->count()) {
            $currentPageID = $this->owner->ID;
            $includeOnPages = $alert->getArrayOfIncludedPageIDs();
            // if the current page is not included as an include rule, then check if it is included as exclude rule
            if (!in_array($currentPageID, $includeOnPages)) {
                $excludeOnPages = $alert->getArrayOfExcludedPageIDs();
                if (in_array($currentPageID, $excludeOnPages)) {
                    $canDisplay = false;
                }
            }
        }
        return $canDisplay;
    }
}
