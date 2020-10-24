<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractDeleteAction;
use Common\Menu\Model\Menu;
use Common\Menu\Model\ResourceModel\Menu as ResourceModel;

class Delete extends AbstractDeleteAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->delete(
            Menu::class,
            ResourceModel::class,
            'Specified menu does not exist.',
            'Menu deleted.'
        );
    }
}
