<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractSaveAction;
use Common\Menu\Model\Menu;
use Common\Menu\Model\ResourceModel\Menu as ResourceModel;

class Save extends AbstractSaveAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->save(
            Menu::class,
            ResourceModel::class,
            'Specified menu does not exist.',
            'Menu saved successfully.',
            'menu_menu'
        );
    }
}
