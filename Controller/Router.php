<?php
/**
 * @package     add-to-homescreen
 * @author      NexPWA <hello@nexpwa.com>
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.nexpwa.com/
 * @copyright   Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 */

namespace NexPWA\AddToHomescreen\Controller;

use NexPWA\AddToHomescreen\Model\Config;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var WebManifestFactory
     */
    private $webManifestFactory;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var ServiceWorkerFactory
     */
    private $serviceWorkerFactory;

    /**
     * Router constructor.
     * @param WebManifestFactory $webManifestFactory
     * @param ServiceWorkerFactory $serviceWorkerFactory
     * @param Config $config
     */
    public function __construct(
        WebManifestFactory $webManifestFactory,
        ServiceWorkerFactory $serviceWorkerFactory,
        Config $config
    )
    {
        $this->webManifestFactory = $webManifestFactory;
        $this->serviceWorkerFactory = $serviceWorkerFactory;
        $this->config = $config;
    }

    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        preg_match("/^(version\d+\/)?manifest\.webmanifest$/", $identifier, $matches);
        if (count($matches) && $this->config->isManifestEnabled()) {
            return $this->webManifestFactory->create();
        }

        preg_match("/^service-worker\.js$/", $identifier, $matches);
        if (count($matches) && $this->config->isServiceWorkerEnabled()) {
            return $this->serviceWorkerFactory->create();
        }

        return null;
    }
}