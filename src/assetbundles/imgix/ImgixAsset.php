<?php
/**
 * Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with the Imgix image-generation service in Craft
 *
 * @link      https://malven.co
 * @copyright Copyright (c) 2019 Chris Malven
 */

namespace malven\imgix\assetbundles\Imgix;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Chris Malven
 * @package   Imgix
 * @since     1.0.0
 */
class ImgixAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@malven/imgix/assetbundles/imgix/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Imgix.js',
        ];

        $this->css = [
            'css/Imgix.css',
        ];

        parent::init();
    }
}
