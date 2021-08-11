<?php

namespace Anastiuk\Vendor\Model;

class Reviews extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    const CACHE_TAG = 'anastiuk_vendor_vendors';

    protected $_cacheTag = 'anastiuk_vendor_vendors';

    protected $_eventPrefix = 'anastiuk_vendor_vendors';

    protected function _construct()
    {
        $this->_init('Anastiuk\Vendor\Model\ResourceModel\Reviews');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
