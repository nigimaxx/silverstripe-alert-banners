<?php

namespace DNADesign\AlertBanners\Model;

use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

class AlertDisplayRule extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'AlertDisplayRule';

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Rule' =>  'Enum("Exclude, Include")',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
        'Rule' => 'Rule',
        'Page.Title' => 'Page Applied To',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Page' => SiteTree::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $titleField = $fields->dataFieldByName('Title');
        $titleField->setDescription('Internal use only - used to identify this rule');
        $fields->replaceField(
            'PageID',
            TreeDropdownField::create(
                'PageID',
                'Page',
                SiteTree::class
            )
        );
        return $fields;
    }


    /**
    * @param mixed $member
    * @param array $context
    * @return boolean
    */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('CMS_ACCESS_DNADesign\AlertBanners\Admin\AlertBannerAdmin');
    }

    /**
    * @param mixed $member
    * @return boolean
    */
    public function canDelete($member = null)
    {
        return Permission::check('CMS_ACCESS_DNADesign\AlertBanners\Admin\AlertBannerAdmin');
    }

    /**
    * @param mixed $member
    * @return boolean
    */
    public function canEdit($member = null)
    {
        return Permission::check('CMS_ACCESS_DNADesign\AlertBanners\Admin\AlertBannerAdmin');
    }

    /**
    * @param mixed $member
    * @return boolean
    */
    public function canView($member = null)
    {
        return Permission::check('CMS_ACCESS_DNADesign\AlertBanners\Admin\AlertBannerAdmin');
    }
}
