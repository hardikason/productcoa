<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Helper\Image;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

/**
 * ViewModel for Getting Product Info
 */
class ProductInfo implements ArgumentInterface
{
    /**
     * module enable config
     *
     */
    private const MODULE_ENABLED = "catalog/productcoa/enable";

    /**
     * Constructor function
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     * @param Image $imageHelper
     * @param OrderRepositoryInterface $orderRepository
     * @param PriceHelper $priceHelper
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected UrlInterface $urlBuilder,
        protected RequestInterface $request,
        protected Image $imageHelper,
        protected OrderRepositoryInterface $orderRepository,
        protected PriceHelper $priceHelper,
    ) {
    }

    /**
     * Check if module is enabled
     *
     * @return mixed
     */
    public function isEnabled(): mixed
    {
        return $this->scopeConfig->getValue(self::MODULE_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get view authentication photo url function
     *
     * @param string $orderItemId
     * @return string
     */
    public function getViewProductAuthenticationPhotoUrl($orderItemId): string
    {
        return $this->urlBuilder->getUrl("productcoa/customer/auth-photo/", ['id'=>(int)$orderItemId]);
    }

    /**
     * Get Product Image Url
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getProductImage(\Magento\Catalog\Model\Product $product): string
    {
        return $this->imageHelper->init($product, 'product_page_image_small')->getUrl();
    }

    /**
     * Get Authentication Photo Url
     *
     * @param string $authPhotoPath
     * @return string
     */
    public function getAuthenticationPhotoUrl($authPhotoPath): string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$authPhotoPath;
    }

    /**
     * Get Order info
     *
     * @return OrderInterface|null
     */
    public function getOrder(): OrderInterface|null
    {

        $orderId = is_numeric($this->request->getParam('id')) ? (int) $this->request->getParam('id') : 0;

        try {
            return $this->orderRepository->get($orderId);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check order has authentication photo available
     *
     * @param Order $order
     * @return boolean
     */
    public function hasAuthenticationPhoto(Order $order):bool
    {
        $orderItems = $order->getAllItems();

        $hasAuthenticationPhoto = false;
        foreach ($orderItems as $item) {
            if ($item->getData('authentication_photo') !== null) {
                $hasAuthenticationPhoto = true;
            }
        }

        return $hasAuthenticationPhoto;
    }

    /**
     * Get Formatted Price function
     *
     * @param float $price
     * @return float|string
     */
    public function getFormattedPrice($price): float|string
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
