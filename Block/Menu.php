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

namespace Common\Menu\Block;

use Common\Menu\Block\Menu\Item\Renderer\AbstractRenderer;
use Common\Menu\Model\Menu as Model;
use Common\Menu\Model\Menu\Item;
use Common\Menu\Model\MenuFactory;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection as ItemCollection;
use Common\Menu\Model\ResourceModel\Menu\Item\CollectionFactory as ItemCollectionFactory;
use Magento\Framework\Data\Tree;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
class Menu extends Template
{
    public const CACHE_KEY_PREFIX = 'MENU_BLOCK_';

    /**
     * @var ItemCollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * @var Model
     */
    protected $menu;

    /**
     * @var MenuFactory
     */
    protected $menuFactory;

    /**
     * @var ResourceMenu
     */
    protected $resourceMenu;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TreeFactory
     */
    protected $treeFactory;

    /**
     * @param ItemCollectionFactory $itemCollectionFactory
     * @param MenuFactory           $menuFactory
     * @param ResourceMenu          $resourceMenu
     * @param StoreManagerInterface $storeManager
     * @param TreeFactory           $treeFactory
     * @param Context               $context
     * @param array                 $data
     */
    public function __construct(
        ItemCollectionFactory $itemCollectionFactory,
        MenuFactory $menuFactory,
        ResourceMenu $resourceMenu,
        StoreManagerInterface $storeManager,
        TreeFactory $treeFactory,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->menuFactory = $menuFactory;
        $this->resourceMenu = $resourceMenu;
        $this->storeManager = $storeManager;
        $this->treeFactory = $treeFactory;
    }

    /**
     * Menu Block > Item Renderer > Item Block
     *
     * @return string
     * @throws LocalizedException
     */
    public function getMenuItemHtml()
    {
        /* @var $itemCollection ItemCollection */
        $itemCollection = $this->itemCollectionFactory->create();
        $itemCollection->addStoreFilter($this->storeManager->getStore())
            ->addFieldToFilter('menu_id', ['eq' => $this->getMenu()->getId()])
            ->addOrder('main_table.order', ItemCollection::SORT_ORDER_ASC);

        /* @var Tree $tree Item model tree */
        $tree = $this->treeFactory->create();
        $rootNode = new Node(['id' => 0], 'id', $tree);
        $tree->addNode($rootNode);
        foreach ($itemCollection as $item) {
            /* @var $item Item */
            $parentNode = $this->getParentNode($tree, $itemCollection, $item->getData('parent_id'));
            $tree->appendChild(array_merge($item->getData(), ['renderer' => $item->getRenderer()]), $parentNode);
        }

        $html = '';
        foreach ($rootNode->getChildren() as $node) {
            /* @var $renderer AbstractRenderer */
            $renderer = $this->getLayout()->createBlock(
                $node->getData('renderer'),
                'menu_item_renderer_' . $node->getData('id'),
                ['data' => ['node' => $node, 'level' => 0]]
            );
            foreach ($renderer->getItemBlocks() as $itemBlock) {
                $html .= $itemBlock->toHtml();
            }
        }
        return $html;
    }

    /**
     * @return Model
     */
    public function getMenu()
    {
        if ($this->menu === null) {
            $this->menu = $this->menuFactory->create();
            if ($this->getData('identifier')) {
                $this->resourceMenu->load($this->menu, $this->getData('identifier'), 'identifier');
            }
        }
        return $this->menu;
    }

    /**
     * @param Tree           $tree
     * @param ItemCollection $itemCollection
     * @param int            $parentId
     * @return Node
     */
    protected function getParentNode($tree, $itemCollection, $parentId)
    {
        if (($parentNode = $tree->getNodeById($parentId)) === null) {
            /* @var $parentItem Item */
            $parentItem = $itemCollection->getItemById($parentId);
            $parentData = $parentItem->getData();
            $parentNode = $tree->appendChild(
                array_merge($parentData, ['renderer' => $parentItem->getRenderer()]),
                $this->getParentNode($tree, $itemCollection, $parentData['parent_id'])
            );
        }
        return $parentNode;
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if (!$this->getMenu()->getId()) {
            return '';
        }
        return parent::_toHtml();
    }
}
