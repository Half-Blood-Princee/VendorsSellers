<?php

namespace Anastiuk\Vendor\Model\ResourceModel\Department;

class CollectionFactory
{
    protected $_objectManager = null;

    protected $_instanceName = null;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Anastiuk\\Vendor\\Model\\ResourceModel\\Reviews\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
