<?php

namespace Anastiuk\Vendor\Model\ResourceModel;

class Reviews extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct() {
        $this->_init('anastiuk_vendor_vendors', 'vendor_id');
    }
}
