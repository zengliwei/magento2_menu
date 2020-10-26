<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractIndexAction;

class Index extends AbstractIndexAction
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_menu';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->parsePage(
            'menu_menu',
            'Common_Menu::menu_menu',
            'Menu'
        );
    }
}
