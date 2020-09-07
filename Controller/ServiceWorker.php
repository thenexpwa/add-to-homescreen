<?php
/**
 * @package     add-to-homescreen
 * @author      NexPWA <hello@nexpwa.com>
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.nexpwa.com/
 * @copyright   Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 */

namespace NexPWA\AddToHomescreen\Controller;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutInterface;

class ServiceWorker extends Action
{
    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * ServiceWorker constructor.
     * @param Context $context
     * @param LayoutInterface $layout
     */
    public function __construct(
        Context $context,
        LayoutInterface $layout
    )
    {
        parent::__construct($context);
        $this->layout = $layout;
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
        /** @var \NexPWA\AddToHomescreen\Block\ServiceWorker $serviceWorker */
        $serviceWorker = $this->layout->createBlock(\NexPWA\AddToHomescreen\Block\ServiceWorker::class);
        /** @var Raw $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $response->setHeader('Content-Type', 'text/javascript');
        $content = $serviceWorker->toHtml();
        preg_match('/<script type="text\/javascript">([\S\s]*)<\/script>/m', $content, $matches);
        $response->setContents(trim($matches[1]));
        return $response;
    }
}