<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractSaveAction;
use Common\Menu\Model\Menu;

class Save extends AbstractSaveAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->save(
            Menu::class,
            'Specified menu does not exist.',
            'Menu saved successfully.',
            'menu_menu'
        );
    }
}
