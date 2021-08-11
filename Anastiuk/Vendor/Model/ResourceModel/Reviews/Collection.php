<?php

namespace Anastiuk\Vendor\Model\ResourceModel\Reviews;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'vendor_id';

    protected $_eventPrefix = 'anastiuk_vendor_reviews_collection';

    protected $_eventObject = 'reviews_collection';

    protected function _construct()
    {
        $this->_init('Anastiuk\Vendor\Model\Reviews', 'Anastiuk\Vendor\Model\ResourceModel\Reviews');

    }
}
