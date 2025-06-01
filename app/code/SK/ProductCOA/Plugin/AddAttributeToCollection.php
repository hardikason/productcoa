<?php
namespace SK\ProductCOA\Plugin;

use Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider;

class AddAttributeToCollection
{
    /**
     * Before GetData function
     *
     * @param ProductDataProvider $subject
     * @return void
     */
    public function beforeGetData(ProductDataProvider $subject)
    {
        $subject->getCollection()->addFieldToSelect('authentication_photo');
    }
}
