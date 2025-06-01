<?php
namespace SK\ProductCOA\Ui\AddField;

use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;

class AuthenticationPhoto implements AddFieldToCollectionInterface
{
    /**
     * All field to collection function
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Collection $collection
     * @param string $field
     * @param string|null $alias
     * @return void
     */
    public function addField(Collection $collection, $field, $alias = null)
    {
        // @phpstan-ignore-next-line
        $collection->addFieldToSelect($field);
    }
}
