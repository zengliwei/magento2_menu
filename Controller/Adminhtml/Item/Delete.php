<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractDeleteAction;
use Common\Menu\Model\Menu\Item;

class Delete extends AbstractDeleteAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->delete(
            Item::class,
            'Specified item does not exist.',
            'Menu item deleted.'
        );
    }
}
