# Imgix plugin for Craft CMS 3.x

Tools for working with the Imgix image-generation service in Craft

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require malven/craft-imgix

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Imgix.

## Use

### Configuration:

Imgix expects the following settings to be configured:

- **Imgix API Key:** Your Imgix API key, obtained from the Imgix control panel.
- **Imgix Source Name:** The name of your source defined in the Imgix control panel.
- **Secure URL Token:** If you have `Secure URL` enabled for your Imgix source, this should be the `Secure URL Token` value listed there.

### Generating Image URLs in Twig:

```twig
{% set url = craft.imgix.url(myAssetField.first, {
    w: 1000,
    h: 800,
    q: 50,
    auto: 'format',
    fit: 'max'
}) %}
```

Any options supported by the Imgix image API can be passed into these options. Imgix will do the work of transforming the original asset URL into the appropriate Imgix URL based on your plugin settings.

### Clearing Imgix Caches:

Whenever an asset in Craft is replaced or deleted, Imgix will attempt to automatically clear the corresponding Imgix cache for that asset.