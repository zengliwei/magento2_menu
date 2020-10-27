<?php

namespace Common\Menu\Setup\Patch\Data;

use Common\Menu\Model\MenuFactory;
use Common\Menu\Model\Menu\ItemFactory;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Common\Menu\Model\ResourceModel\Menu\Item as ResourceItem;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DefaultMenu implements DataPatchInterface
{
    /**
     * @var MenuFactory
     */
    private $menuFactory;

    /**
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * @var ResourceMenu
     */
    private $resourceMenu;

    /**
     * @var ResourceItem
     */
    private $resourceItem;

    /**
     * @param MenuFactory  $menuFactory
     * @param ItemFactory  $itemFactory
     * @param ResourceMenu $resourceMenu
     * @param ResourceItem $resourceItem
     */
    public function __construct(
        MenuFactory $menuFactory,
        ItemFactory $itemFactory,
        ResourceMenu $resourceMenu,
        ResourceItem $resourceItem
    ) {
        $this->menuFactory = $menuFactory;
        $this->itemFactory = $itemFactory;
        $this->resourceMenu = $resourceMenu;
        $this->resourceItem = $resourceItem;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $menuSource = [
            [
                'data'  => ['identifier' => 'main_menu', 'name' => 'Main Menu'],
                'items' => [
                    ['title' => 'Home', 'url' => '/', 'order' => 1],
                    ['title' => 'Catalog Tree', 'type' => 'catalog_category_tree', 'order' => 2]
                ]
            ],
            [
                'data'  => ['identifier' => 'footer_menu', 'name' => 'Footer Menu'],
                'items' => [
                    ['title' => 'Search Terms', 'url' => 'search/term/popular', 'order' => 1],
                    ['title' => 'Orders and Returns', 'url' => 'sales/guest/form', 'order' => 2],
                    ['title' => 'Advanced Search', 'url' => 'catalogsearch/advanced', 'order' => 3],
                    ['title' => 'Contact Us', 'url' => 'contact', 'order' => 4]
                ]
            ]
        ];
        foreach ($menuSource as $menuData) {
            $menu = $this->menuFactory->create();
            $this->resourceMenu->save($menu->setData($menuData['data']));
            foreach ($menuData['items'] as $itemData) {
                $itemData['menu_id'] = $menu->getId();
                $item = $this->itemFactory->create();
                $this->resourceItem->save($item->setData($itemData));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
