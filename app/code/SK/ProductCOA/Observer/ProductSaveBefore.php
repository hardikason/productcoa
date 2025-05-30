<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class ProductSaveBefore implements ObserverInterface
{

    /**
     * Authentication photo upload directory config
     */
    private const UPLOAD_DIR = 'catalog/productcoa/auth_images_dir';
    
    /**
     * Constructor function
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * Execute observer on product save
     *
     * @param Observer $observer
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        try {
            /** @var \Magento\Catalog\Model\Product $product */
            $product = $observer->getEvent()->getData('product');
            
            $authenticationPhoto = $product->getData('authentication_photo');

            if (is_array($authenticationPhoto)) {
                $product->setData(
                    'authentication_photo',
                    $this->getAuthDirName(). '/' .$authenticationPhoto[0]['name']
                );
            } else {
                $product->setData('authentication_photo', null);
            }
        } catch (\Exception $e) {
            $this->logger->error('Product save error: ' . $e->getMessage());
        }
    }

    /**
     * Get authentication upload photo directory
     *
     * @return mixed
     */
    public function getAuthDirName(): mixed
    {
        return $this->scopeConfig->getValue(self::UPLOAD_DIR, ScopeInterface::SCOPE_STORE);
    }
}
