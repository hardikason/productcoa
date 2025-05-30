<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\Plugin\Quote\Item;

use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Sales\Model\Order\Item as OrderItem;
use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Quote\Model\Quote\Item as QuoteItem;

class ToOrderItemPlugin
{
    /**
     * Constructor function
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Transfer authentication_photo from quote item to order item
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param ToOrderItem $subject
     * @param OrderItem $result
     * @param QuoteItem $item
     * @param array<string, mixed> $additional
     * @return OrderItem
     */
    public function afterConvert(
        ToOrderItem $subject,
        OrderItem $result,
        QuoteItem $item,
        array $additional = []
    ): OrderItem {

        if ($item->getSku()) {
   
            $product = $this->productRepository->get($item->getSku());

            $authPhoto = $product->getCustomAttribute('authentication_photo');
            if ($authPhoto) {
                $authPhotoValue = $authPhoto->getValue();
                $result->setData('authentication_photo', $authPhotoValue);
            }
        }

        return $result;
    }
}
