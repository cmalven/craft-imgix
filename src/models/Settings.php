<?php
/**
 * Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with the Imgix image-generation service in Craft
 *
 * @link      https://malven.co
 * @copyright Copyright (c) 2019 Chris Malven
 */

namespace malven\imgix\models;

use malven\imgix\Imgix;

use Craft;
use craft\base\Model;

/**
 * @author    Chris Malven
 * @package   Imgix
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public $imgixApiKey = '';
    public $sourceDomain = '';
    public $securityToken = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imgixApiKey', 'sourceDomain'], 'required'],

            ['imgixApiKey', 'string'],
            ['imgixApiKey', 'default', 'value' => ''],

            ['sourceDomain', 'string'],
            ['sourceDomain', 'default', 'value' => ''],

            ['securityToken', 'string'],
            ['securityToken', 'default', 'value' => ''],
        ];
    }
}
