<?php

namespace Common\Menu\Model;

use Magento\Framework\Model\AbstractModel;

class Menu extends AbstractModel
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Menu::class);
    }
}
