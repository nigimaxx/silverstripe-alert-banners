<?php

namespace DNADesign\AlertBanners\Model;

use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;

class AlertBanner extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'AlertBanner';

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class,
    ];

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Type' =>  'Enum("Info, Warning, Error")',
        'Content' => 'HTMLText',
        'DisplayFrom' => 'Datetime',
        'DisplayTo' => 'Datetime',
    ];

    /**
     * @var array
     */
    private static $many_many = [
        'DisplayRules' => AlertDisplayRule::class,
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'ID' => 'ID',
        'Title' => 'Title',
        'Created' => 'Created',
        'ValidDateRange' => 'Displayed',
        'Type' => 'Theme',
        'Status' => 'Status',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title',
        'Type',
    ];

    /**
     * @var string
     */
    private static $default_sort = 'ID DESC';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        // main tab
        $contentField = $fields->dataFieldByName('Content');
        $contentField->setEditorConfig('alert-banners')->setRows(4);

        // display rules tab
        $gridField = $fields->dataFieldByName('DisplayRules');
        $gridField->setDescription(
            '<p class="alert alert-primary">
                This alert banner will be displayed on all pages be default. You can add exclude/include rules for pages here.<br>
                This alert banner will <strong>always show</strong> on pages that are added as an <strong>include</strong> rule.<br>
                This alert banner will not be shown on pages (or any of their child pages) that are added as an <strong>exclude</strong> rule.
            </p>'
        );
        return $fields;
    }

    /**
     * Summary Field - returns information about when the alert banner will be displayed
     * @return DBHTMLText
     */
    public function getValidDateRange()
    {
        $validDateRange = 'From: ' . $this->dbObject('DisplayFrom')->Nice();
        $validDateRange .= '';
        if (!$this->DisplayFrom) {
            $validDateRange = 'Start Date Required';
        } elseif ($this->DisplayTo) {
            $validDateRange .= '<br>To: ' . $this->dbObject('DisplayTo')->Nice();
        }
        return DBField::create_field(DBHTMLText::class, $validDateRange);
    }

    /**
     * Summary Field - returns current status of the alert banner
     * @return DBHTMLText
     */
    public function getStatus()
    {
        $status = '';
        $published = $this->isPublished();
        if (!$published) {
            $status = '<i class="font-icon-pencil btn--icon-md"></i>Draft';
        } else {
            $status =  '<i class="font-icon-check-mark-circle btn--icon-md"></i>Published';
        }
        return DBField::create_field(DBHTMLText::class, $status);
    }

    /**
     * CSS modifier
     * @return string
     */
    public function Modifier()
    {
        return strtolower($this->Type);
    }
}
