<?php

namespace Common\Menu\Setup\Patch;

use Common\Menu\Model\Menu;
use Common\Menu\Model\Menu\Item;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Common\Menu\Model\ResourceModel\Menu\Item as ResourceMenuItem;
use Magento\Framework\Exception\AlreadyExistsException;

trait TraitMenuData
{
    /**
     * @return ResourceMenu
     */
    private function getResourceMenu()
    {
        return $this->objectManager->get(ResourceMenu::class);
    }

    /**
     * @return ResourceMenuItem
     */
    private function getResourceMenuItem()
    {
        return $this->objectManager->get(ResourceMenuItem::class);
    }

    /**
     * @return Menu
     */
    private function createMenuModel()
    {
        return $this->objectManager->create(Menu::class);
    }

    /**
     * @return Item
     */
    private function createMenuItemModel()
    {
        return $this->objectManager->create(Item::class);
    }

    /**
     * @param string $identifier
     * @return Menu
     */
    private function getMenuModel($identifier)
    {
        $menu = $this->objectManager->create(Menu::class);
        $this->getResourceMenu()->load($menu, $identifier, 'identifier');
        return $menu;
    }

    /**
     * @param Menu $menu
     * @throws AlreadyExistsException
     */
    private function saveMenu(Menu $menu)
    {
        $this->getResourceMenu()->save($menu);
    }

    /**
     * @param Item $menuItem
     * @throws AlreadyExistsException
     */
    private function saveMenuItem(Item $menuItem)
    {
        $this->getResourceMenuItem()->save($menuItem);
    }

    /**
     * @param array $itemSource
     * @param int   $menuId
     * @param int   $parentId
     * @throws AlreadyExistsException
     */
    private function appendMenuItemTree($itemSource, $menuId, $parentId = 0)
    {
        foreach ($itemSource as $itemData) {
            $itemData['menu_id'] = $menuId;
            $itemData['parent_id'] = $parentId;
            $item = $this->createMenuItemModel();
            $this->getResourceMenuItem()->save($item->setData($itemData));
            if (!empty($itemData['children'])) {
                $this->appendMenuItemTree($itemData['children'], $menuId, $item->getId());
            }
        }
    }
}
