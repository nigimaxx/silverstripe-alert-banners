<?php

namespace DNADesign\AlertBanners\Control;

use DateTime;
use DNADesign\AlertBanners\Model\AlertBanner;
use SilverStripe\Core\Extension;

class ControllerExtension extends Extension
{
    /**
     * Alert banners to be displayed on the front end
     * @return Datalist
     */
    public function AlertBanners()
    {
        return AlertBanner::get()
            ->filterByCallback(function ($alert) {
                return $this->canDisplay($alert);
            });
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

        // then check if the current page is affected by any of this alert banners display rules
        if ($canDisplay && $alert->DisplayRules()->count()) {
            $currentPageID = $this->owner->ID;
            $includeOnPages = $this->getArrayOfIncludedPageIDs($alert);
            // if the current page is not included as an include rule, then check if it is included as exclude rule
            if (!in_array($currentPageID, $includeOnPages)) {
                $excludeOnPages = $this->getArrayOfExcludedPageIDs($alert);
                if (in_array($currentPageID, $excludeOnPages)) {
                    $canDisplay = false;
                }
            }
        }
        return $canDisplay;
    }

    /**
     * Returns an array of page ID's for which the alert banner should be displayed on
     * @return array
     */
    public function getArrayOfIncludedPageIDs($alert)
    {
        $ids = [];
        $includeRules = $alert->DisplayRules()->filter(['Rule' => 'Include']);
        foreach ($includeRules as $includeRule) {
            $page = $includeRule->Page();
            $ids[] = $page->ID;
        }
        return $ids;
    }

    /**
     * Returns an array of page ID's for which the alert banner should NOT be displayed on
     * @return array
     */
    public function getArrayOfExcludedPageIDs($alert)
    {
        $ids = [];
        $excludeRules = $alert->DisplayRules()->filter(['Rule' => 'Exclude']);
        foreach ($excludeRules as $excludeRule) {
            $page = $excludeRule->Page();
            $ids[] = $page->ID;
            $ids = array_merge($ids, $page->getDescendantIDList());
        }
        return $ids;
    }
}
