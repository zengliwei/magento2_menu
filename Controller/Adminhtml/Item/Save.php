<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractSaveAction;
use Common\Menu\Model\Menu\Item;
use Common\Menu\Model\ResourceModel\Menu\Item as ResourceModel;

class Save extends AbstractSaveAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->save(
            Item::class,
            ResourceModel::class,
            'Specified item does not exist.',
            'Menu item saved successfully.',
            'menu_item'
        );
    }
}
