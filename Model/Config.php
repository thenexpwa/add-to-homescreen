<?php
/**
 * @package     add-to-homescreen
 * @author      NexPWA <hello@nexpwa.com>
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.nexpwa.com/
 * @copyright   Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 */

namespace NexPWA\AddToHomescreen\Model;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var array
     */
    private $data;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->data = $data;
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isManifestEnabled()
    {
        return (bool)$this->getValue('pwa/manifest/is_active');
    }

    /**
     * @return bool
     */
    public function isServiceWorkerEnabled()
    {
        return (bool)$this->getValue('pwa/service_worker/is_active');
    }

    /**
     * @return string
     */
    public function getCacheVersion()
    {
        return $this->getValue('pwa/service_worker/cache_version');
    }

    /**
     * @return array
     */
    public function getPrecacheUrls()
    {
        return explode(
            ',',
            trim(
                preg_replace(
                    '/\s\s+/',
                    ' ',
                    $this->getValue('pwa/service_worker/precache_urls')
                )
            )
        );
    }

    /**
     * @return bool
     */
    public function isShowCachedData()
    {
        return (bool)$this->getValue('pwa/service_worker/show_cached_data');
    }

    /**
     * @return string
     */
    public function getNoInternetHtml()
    {
        return trim(
            preg_replace(
                '/\s\s*/',
                ' ',
                $this->getValue('pwa/service_worker/no_internet_html')
            )
        );
    }

    /**
     * @return bool
     */
    public function isOfflineIndicatorActive()
    {
        return (bool)$this->getValue('pwa/general/is_offline_indicator_active');
    }

    /**
     * @return array
     */
    public function getManifestData()
    {
        return [
            "short_name" => $this->getValue('pwa/manifest/short_name'),
            "name" => $this->getValue('pwa/manifest/name'),
            "description" => $this->getValue('pwa/manifest/description'),
            "start_url" => $this->getValue('pwa/manifest/start_url'),
            "scope" => "/",
            "display" => $this->getValue('pwa/manifest/display'),
            "background_color" => $this->getValue('pwa/manifest/background_color'),
            "theme_color" => $this->getValue('pwa/manifest/theme_color'),
            "icons" => [
                [
                    "src" => $this->getIconUrl('pwa/manifest/icon_192'),
                    "type" => "image/png",
                    "sizes" => "192x192"
                ],
                [
                    "src" => $this->getIconUrl('pwa/manifest/icon_512'),
                    "type" => "image/png",
                    "sizes" => "512x512"
                ],
                [
                    "src" => $this->getIconUrl('pwa/manifest/icon_1024'),
                    "type" => "image/png",
                    "sizes" => "1024x1024"
                ]
            ],
            "shortcuts" => []
        ];
    }

    /**
     * @param $path
     * @return string
     */
    protected function getIconUrl($path)
    {
        $value = $this->getValue($path);
        try {
            return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'pwa/manifest/icons/' . $value;
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @param string $path
     * @param string $scope
     * @param bool $loadFromCache
     * @return string
     */
    public function getValue($path, $scope = ScopeInterface::SCOPE_STORE, $loadFromCache = true)
    {
        $key = $path.$scope;
        if (!array_key_exists($key, $this->data)) {
            $this->data[$key] = $this->scopeConfig->getValue($path, $scope);
        }
        return $loadFromCache ? $this->data[$key] : $this->scopeConfig->getValue($path, $scope);
    }
}