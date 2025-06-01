<?php
namespace SK\ProductCOA\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class AuthenticationPhoto extends Column
{
    /**
     * Get authentication photo data in grid function
     *
     * @param array<int|string> $dataSource
     * @return array<int|string, mixed>
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = !empty($item['authentication_photo']) ? __('Yes') : __('No');
            }
        }
        return $dataSource;
    }
}
