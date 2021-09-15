<?php

namespace DNADesign\AlertBanners\Admin;

use DNADesign\AlertBanners\Model\AlertBanner;
use DNADesign\AlertBanners\Model\AlertDisplayRule;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldImportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class AlertBannerAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = [
        AlertBanner::class,
        AlertDisplayRule::class,
    ];

    /**
     * @var string
     */
    private static $url_segment = 'alert-banners';

    /**
     * @var string
     */
    private static $menu_title = 'Alert Banners';

    /**
     * @var string
     */
    private static $menu_icon_class = 'font-icon-attention';

    /**
     * @param Int $id
     * @param FieldList $fields
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        $models = Config::inst()->get(self::class, 'managed_models');
        foreach ($models as $model) {
            $field = $form->Fields()->dataFieldByName($this->sanitiseClassName($model));
            if ($field) {
                $config = $field->getConfig();
                $config->removeComponentsByType(
                    [
                        GridFieldImportButton::class,
                        GridFieldExportButton::class,
                        GridFieldPrintButton::class,
                    ]
                );

                if($model === AlertBanner::class){
                  $config->addComponent($sortable = new GridFieldSortableRows('SortOrder'));
                  $sortable->setAppendToTop(true);
                  $sortable->setUpdateVersionedStage('Live');
                }
            }
        }
        return $form;
    }
}
