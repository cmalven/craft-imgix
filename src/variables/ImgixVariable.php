<?php
/**
 * Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with the Imgix image-generation service in Craft
 *
 * @link      https://malven.co
 * @copyright Copyright (c) 2019 Chris Malven
 */

namespace malven\imgix\variables;

use malven\imgix\Imgix;

use Craft;

/**
 * @author    Chris Malven
 * @package   Imgix
 * @since     1.0.0
 */
class ImgixVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the URL for an asset via Imgix
     * 
     * {{ craft.imgix.url(myAsset, {
     *   w: 1000,
     *   h: 800,
     *   q: 50,
     *   auto: 'format',
     *   fit: 'max'
     * }) }}
     *
     * @param    <type>  $asset   The asset
     * @param    array   $params  The parameters
     *
     * @return   <type>  ( description_of_the_return_value )
     */
    public function url($asset, $params = [])
    {
        return Imgix::$plugin->imgixService->url($asset, $params);
    }
}
