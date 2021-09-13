<?php

namespace DNADesign\AlertBanners\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Versioned\Versioned;

class AlertBanner extends DataObject
{
    private static $table_name = 'AlertBanner';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Type' =>  'Enum("Info, Warning, Error")',
        'Content' => 'HTMLText',
        'DisplayFrom' => 'Datetime',
        'DisplayTo' => 'Datetime',
    ];

    private static $summary_fields = [
        'ID' => 'ID',
        'Title' => 'Title',
        'Created' => 'Created',
        'ValidDateRange' => 'Displayed',
        'Type' => 'Theme',
        'Status' => 'Status',
    ];

    private static $searchable_fields = [
        'Title',
        'Type',
    ];

    private static $extensions = [
        Versioned::class,
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $contentField = $fields->dataFieldByName('Content');
        $contentField->setEditorConfig('alert-banners')->setRows(4);
        return $fields;
    }

    public function getValidDateRange()
    {
        $validDateRange = 'From: ' . $this->dbObject('DisplayFrom')->Nice();
        $validDateRange .= '';
        if (!$this->DisplayFrom) {
            $validDateRange = 'Start Date Required';
        } elseif ($this->DisplayTo) {
            $validDateRange .= '<br>To: ' . $this->dbObject('DisplayTo')->Nice();
        }
        return DBField::create_field('HTMLText', $validDateRange);
    }

    public function getStatus()
    {
        $status = '';
        $published = $this->isPublished();
        if (!$published) {
            $status = '<i class="font-icon-pencil btn--icon-md"></i>Draft';
        } else {
            $status =  '<i class="font-icon-check-mark-circle btn--icon-md"></i>Published';
        }
        return DBField::create_field('HTMLText', $status);
    }

    public function Modifier()
    {
        return strtolower($this->Type);
    }
}
