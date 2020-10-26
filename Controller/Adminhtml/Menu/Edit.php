<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractEditAction;
use Common\Menu\Model\Menu;

class Edit extends AbstractEditAction
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_menu';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->render(
            Menu::class,
            'Specified menu does not exist.',
            'Common_Menu::menu_menu',
            'Create Menu',
            'Edit Menu (ID: %1)'
        );
    }
}
