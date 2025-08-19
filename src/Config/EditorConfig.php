<?php

namespace DNADesign\AlertBanners\Config;

use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;

class EditorConfig
{
    /**
     * Creates a new 'alert-banners' HTMLEditorConfig
     */
    public static function create()
    {
        $editor = HTMLEditorConfig::get('alert-banners');
        // Start with the same configuration as 'cms' config (defined in framework/admin/_config.php).
        $editor->setOptions([
            'friendly_name' => 'Alert Banners Editor',
            'skin' => 'silverstripe'
        ]);
        // Enable insert-link to internal pages
        $tinyMceModule = ModuleLoader::inst()->getManifest()->getModule('silverstripe/htmleditor-tinymce');
        $editor->enablePlugins([
            'sslinkinternal' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-internal.js'),
            'sslinkanchor' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-anchor.js'),
            'contextmenu' => null,
            'image' => null,
            'sslink' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink.js'),
            'sslinkexternal' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-external.js'),
            'sslinkemail' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-email.js'),
        ])->setOption('contextmenu', 'sslink ssmedia ssembed inserttable | cell row column deletetable');

        $editor->removeButtons(
            'alignleft',
            'aligncenter',
            'alignright',
            'alignjustify',
            'underline',
            'indent',
            'outdent',
            'bullist',
            'numlist',
            'formatselect',
            'paste',
            'pastetext',
            'code',
            'table',
            'sslink'
        );

        $editor->addButtonsToLine(1, 'sslink', 'code');
    }
}
