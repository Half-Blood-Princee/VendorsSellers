<?php

namespace Anastiuk\Vendor\Ui\DataProvider\Reviews;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        $this->addFilterToMap('vendor_id', 'main_table.vendor_id');
        $this->addFilterToMap('email', 'anastiukvendor.email');
        parent::_initSelect();
    }
}

