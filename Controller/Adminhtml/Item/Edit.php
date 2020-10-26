<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractEditAction;
use Common\Menu\Model\Menu\Item;

class Edit extends AbstractEditAction
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_item';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->render(
            Item::class,
            'Specified item does not exist.',
            'Common_Menu::menu_item',
            'Create Menu Item',
            'Edit Menu Item (ID: %1)'
        );
    }
}
