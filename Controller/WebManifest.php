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
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

class WebManifest extends Action
{
    /**
     * @var Config
     */
    private $config;

    /**
     * WebManifest constructor.
     * @param Context $context
     * @param Config $config
     */
    public function __construct(
        Context $context,
        Config $config
    )
    {
        parent::__construct($context);
        $this->config = $config;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($this->config->getManifestData());
        return $response;
    }
}