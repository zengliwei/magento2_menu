<?php

namespace Common\Menu\Model\Menu;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\Store;

class Item extends AbstractModel
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(\Common\Menu\Model\ResourceModel\Menu\Item::class);
    }
}
