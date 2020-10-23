<?php

namespace Common\Menu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Menu extends AbstractDb
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init('menu', 'id');
    }
}
