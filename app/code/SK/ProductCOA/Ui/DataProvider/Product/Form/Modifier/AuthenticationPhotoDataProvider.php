<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\Filesystem\Io\File as IOFile;

class AuthenticationPhotoDataProvider extends AbstractModifier
{
    /**
     * Constructor function
     *
     * @param UrlInterface $urlBuilder
     * @param LocatorInterface $locator
     * @param IOFile $ioFile
     */
    public function __construct(
        protected UrlInterface $urlBuilder,
        protected LocatorInterface $locator,
        protected IOFile $ioFile
    ) {
    }

    /**
     * Function to send authentication photo data in form
     *
     * @param array<int|string> $data
     * @return array<int|string, mixed>
     */
    public function modifyData(array $data):array
    {
        $product = $this->locator->getProduct();

        /** @var int $productId */
        $productId = $product->getId();

        $attribute = $product->getCustomAttribute('authentication_photo');
        
        /** @var string|null $value */
        $value = $attribute ? $attribute->getValue() : null;
        
        if (is_string($value) && $value !== '') {
            /** @var array<string, string>|false $fileInfo */
            $fileInfo = $this->ioFile->getPathInfo($value);

            if (is_array($fileInfo) && isset($fileInfo['basename'])) {
                $basename = $fileInfo['basename'];
                if (isset($data[$productId]['product'])) {
                    $data[$productId]['product']['authentication_photo'] = [
                        [
                            'name' => $basename,
                            'url'  => $this->getMediaUrl() . $value,
                            'type' => 'image/jpeg',
                        ]
                    ];
                }
            }
        }

        return $data;
    }

    /**
     * Modify Meta function
     *
     * @param array<array<string,mixed>> $meta
     * @return array<int|string, mixed>
     */
    public function modifyMeta(array $meta):array
    {
        return $meta;
    }

    /**
     * Get media url
     *
     * @return string
     */
    protected function getMediaUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);
    }
}
