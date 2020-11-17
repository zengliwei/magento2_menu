<?php
/*
 * Copyright (c) 2020 Zengliwei
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Common\Menu\Model;

use Common\Menu\Api\MenuRepositoryInterface;
use Common\Menu\Helper\Menu as MenuHelper;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Common\Menu\Model\ResourceModel\Menu\Collection as MenuCollection;
use Common\Menu\Model\ResourceModel\Menu\CollectionFactory as MenuCollectionFactory;
use Common\Menu\Model\ResourceModel\Menu\Item\CollectionFactory as MenuItemCollectionFactory;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
class MenuRepository implements MenuRepositoryInterface
{
    /**
     * @var MenuCollectionFactory
     */
    private $menuCollectionFactory;

    /**
     * @var MenuFactory
     */
    private $menuFactory;

    /**
     * @var MenuHelper
     */
    private $menuHelper;

    /**
     * @var ResourceMenu
     */
    private $resourceMenu;

    /**
     * @var MenuItemCollectionFactory
     */
    private $menuItemCollectionFactory;

    /**
     * @param MenuCollectionFactory     $menuCollectionFactory
     * @param MenuFactory               $menuFactory
     * @param MenuHelper                $menuHelper
     * @param ResourceMenu              $resourceMenu
     * @param MenuItemCollectionFactory $menuItemCollectionFactory
     */
    public function __construct(
        MenuCollectionFactory $menuCollectionFactory,
        MenuFactory $menuFactory,
        MenuHelper $menuHelper,
        ResourceMenu $resourceMenu,
        MenuItemCollectionFactory $menuItemCollectionFactory
    ) {
        $this->menuCollectionFactory = $menuCollectionFactory;
        $this->menuFactory = $menuFactory;
        $this->menuHelper = $menuHelper;
        $this->resourceMenu = $resourceMenu;
        $this->menuItemCollectionFactory = $menuItemCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getMenus()
    {
        /* @var MenuCollection $menuCollection */
        return $this->menuCollectionFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function getItemTree($identifier, $storeId = null)
    {
        $menu = $this->menuFactory->create();
        $this->resourceMenu->load($menu, $identifier, 'identifier');
        return $this->menuHelper->getItemTree($menu->getId(), $storeId);
    }
}
