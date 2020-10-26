<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractIndexAction;

class Index extends AbstractIndexAction
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_item';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->render(
            'menu_item',
            'Common_Menu::menu_item',
            'Menu Items'
        );
    }
}
