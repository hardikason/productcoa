<?php

declare(strict_types=1);

namespace SK\ProductCOA\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;

class AddProductAttribute implements DataPatchInterface
{
    /**
     * Constructor function
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     */
    public function __construct(
        protected EavSetupFactory $eavSetupFactory,
        protected Config $eavConfig
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Create new attribute
     *
     * @return $this
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->removeAttribute(Product::ENTITY, 'authentication_photo');
        $eavSetup->addAttribute(
            Product::ENTITY,
            'authentication_photo',
            [
                'type' => 'varchar',
                'label' => 'Authentication Photo',
                'input' => 'media_image',
                'frontend' => \Magento\Catalog\Model\Product\Attribute\Frontend\Image::class,
                'required' => false,
                'sort_order' => 100,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'user_defined' => true,
                'group' => 'Authentication Photo',
                'used_in_product_listing' => true,
                'visible_on_front' => true,
            ]
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
