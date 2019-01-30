<?php
/**
 * Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with the Imgix image-generation service in Craft
 *
 * @link      https://malven.co
 * @copyright Copyright (c) 2019 Chris Malven
 */

namespace malven\imgix;

use malven\imgix\services\ImgixService as ImgixServiceService;
use malven\imgix\variables\ImgixVariable;
use malven\imgix\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;
use craft\services\Assets;
use craft\events\ReplaceAssetEvent;

use yii\base\Event;

/**
 * Class Imgix
 *
 * @author    Chris Malven
 * @package   Imgix
 * @since     1.0.0
 *
 * @property  ImgixServiceService $imgixService
 */
class Imgix extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Imgix
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('imgix', ImgixVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'imgix',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        // Clear the imgix cache when an asset changes
        Event::on(
            Assets::class,
            Assets::EVENT_AFTER_REPLACE_ASSET,
            function (ReplaceAssetEvent $event) {
                Craft::debug(
                    'Assets::EVENT_AFTER_REPLACE_ASSET',
                    __METHOD__
                );
                $asset = $event->asset;
                Imgix::$plugin->imgixService->purgeAsset($asset);
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'imgix/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
