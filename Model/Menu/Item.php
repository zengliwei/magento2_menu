<?php

namespace Common\Menu\Model\Menu;

use Common\Base\Model\AbstractStoreModel;

class Item extends AbstractStoreModel
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(\Common\Menu\Model\ResourceModel\Menu\Item::class);
    }
}
