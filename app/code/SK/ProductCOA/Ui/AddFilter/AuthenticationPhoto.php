<?php
namespace SK\ProductCOA\Ui\AddFilter;

use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

class AuthenticationPhoto implements AddFilterToCollectionInterface
{
    /**
     * Add filter for authentication photo
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Collection $collection
     * @param string $field
     * @param string|null $condition
     * @return void
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        // @phpstan-ignore-next-line
        if ($condition['eq'] == 1) {
            $collection->addFieldToFilter('authentication_photo', ['notnull' => true]);
        } else {
            $collection->addFieldToFilter('authentication_photo', ['null' => true]);
        }
    }
}
