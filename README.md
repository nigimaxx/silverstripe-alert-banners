# SilverStripe Alert Banners

Allows management of alert banners that can be dismissed by users.

JavaScript functionality is included which will hide the banner and set an item on session storage so that the user will not see the banner again for as long as the user's browser session lasts.

No styles are included so you will need to create your own.

## Disable Alert Types

If the `alert_types` configuration is left empty, the dropdown for selecting the alert type will **not** be displayed in the CMS.
To disable the alert types, add the following to your project's configuration:

```yaml
DNADesign\AlertBanners\Model\AlertBanner:
  alert_types:
```

## Editor configuration

The editor_config setting allows you to specify a custom configuration for the WYSIWYG editor in the CMS. If you want to apply a specific editor configuration, add the following to your project’s configuration:

```yaml
MyNamespace\MyClass:
  editor_config: MyEditorConfig
```

 If no editor_config is defined, the default editor settings will be used.