<?php
/**
 * @package     add-to-homescreen
 * @author      NexPWA <hello@nexpwa.com>
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.nexpwa.com/
 * @copyright   Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 */

namespace NexPWA\AddToHomescreen\Block;


use NexPWA\AddToHomescreen\Model\Config;
use Magento\Framework\View\Element\Template;

class ServiceWorker extends Template
{
    protected $_template = 'NexPWA_AddToHomescreen::service_worker.phtml';
    /**
     * @var Config
     */
    private $config;

    /**
     * ServiceWorker constructor.
     * @param Template\Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Config $config,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getPreCacheUrls()
    {
        return $this->config->getPrecacheUrls();
    }

    /**
     * @return string
     */
    public function getCacheVersion()
    {
        return $this->config->getCacheVersion();
    }

    /**
     * @return bool
     */
    public function isShowCachedData()
    {
        return (bool)$this->config->isShowCachedData();
    }

    /**
     * @return string
     */
    public function getNoInternetHtml()
    {
        return $this->config->getNoInternetHtml();
    }
}