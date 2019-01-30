<?php
/**
 * Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with the Imgix image-generation service in Craft
 *
 * @link      https://malven.co
 * @copyright Copyright (c) 2019 Chris Malven
 */

namespace malven\imgix\services;

use malven\imgix\Imgix;

use Craft;
use craft\base\Component;

use craft\helpers\UrlHelper;
use Imgix\UrlBuilder;
use Psr\Http\Message\ResponseInterface;

/**
 * @author    Chris Malven
 * @package   Imgix
 * @since     1.0.0
 */
class ImgixService extends Component
{
    // Public Methods
    // =========================================================================

    public function getApiKey()
    {
        return Imgix::$plugin->getSettings()->imgixApiKey;
    }

    public function getImgixDomain()
    {
        return Imgix::$plugin->getSettings()->sourceDomain;
    }

    public function getSecurityToken()
    {
        return Imgix::$plugin->getSettings()->securityToken;
    }

    public function builtImgixUrl($asset, $params = [])
    {
        $imgixUrl = $this->getImgixDomain();
        $builder = new UrlBuilder($imgixUrl);
        $builder->setUseHttps(true);
        $filepath = $asset->volume->getSettings()['subfolder'] . '/' . $asset->path;
        $securityToken = $this->getSecurityToken();
        if (strlen($securityToken)) {
          $builder->setSignKey($securityToken);
        }
        return $builder->createURL($filepath, $params);
    }

    public function url($asset, $params = [])
    {
      return $this->builtImgixUrl($asset, $params);
    }

    public function purgeAsset($asset)
    {
      $url = UrlHelper::stripQueryString($this->builtImgixUrl($asset, []));
      $result = $this->purgeImgixUrl($url);
    }

    public function purgeImgixUrl($imageUrl)
    {
        $result = false;
        $apiKey = $this->getApiKey();
        $purgeUrl = 'https://api.imgix.com/v2/image/purger';

        $guzzleClient = Craft::createGuzzleClient(['timeout' => 120, 'connect_timeout' => 120]);

        try {
            $response = $guzzleClient->post($purgeUrl, [
                'auth' => [
                    $apiKey,
                    '',
                ],
                'form_params' => [
                    'url' => $imageUrl,
                ],
            ]);

            // Did we succeed
            if (($response->getStatusCode() >= 200)
                && ($response->getStatusCode() < 400)
            ) {
                $result = true;
            }
            Craft::info(
                'URL purged: ' . $imageUrl . ' - Response code: ' . $response->getStatusCode(),
                __METHOD__
            );
        } catch (\Exception $e) {
            Craft::error(
                'Error purging URL: ' . $imageUrl . ' - ' . $e->getMessage(),
                __METHOD__
            );
        }

        return $result;
    }
}
