<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Common\Base\Controller\Adminhtml\AbstractEditAction;
use Common\Menu\Model\Menu;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Edit extends AbstractEditAction implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_menu';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->parsePage(
            Menu::class,
            ResourceMenu::class,
            'Specified menu does not exist.',
            'IndieMenu::menu_menu',
            'Create Menu',
            'Edit Menu (ID: %1)'
        );
    }
}
