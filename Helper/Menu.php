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

namespace Common\Menu\Helper;

use Common\Menu\Api\Data\MenuItemInterface;
use Common\Menu\Block\Menu\Item\Renderer\AbstractRenderer;
use Common\Menu\Model\Menu\Item;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection as ItemCollection;
use Common\Menu\Model\ResourceModel\Menu\Item\CollectionFactory as ItemCollectionFactory;
use Magento\Framework\Data\Tree;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\LayoutInterface;
use Magento\Store\Model\StoreManagerInterface;

class Menu
{
    /**
     * @var ItemCollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * @var LayoutInterface
     */
    protected $layout;

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
     * @param LayoutInterface       $layout
     * @param StoreManagerInterface $storeManager
     * @param TreeFactory           $treeFactory
     */
    public function __construct(
        ItemCollectionFactory $itemCollectionFactory,
        LayoutInterface $layout,
        StoreManagerInterface $storeManager,
        TreeFactory $treeFactory
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->layout = $layout;
        $this->storeManager = $storeManager;
        $this->treeFactory = $treeFactory;
    }

    /**
     * Menu Block > Item Renderer > Item Block
     *
     * @param int             $menuId
     * @param int|string|null $storeId
     * @return MenuItemInterface[]
     * @throws NoSuchEntityException
     */
    public function getItemTree($menuId, $storeId = null)
    {
        /* @var $itemCollection ItemCollection */
        $itemCollection = $this->itemCollectionFactory->create();
        $itemCollection->addStoreFilter($this->storeManager->getStore($storeId))
            ->addFieldToFilter('menu_id', ['eq' => $menuId])
            ->addOrder('main_table.order', ItemCollection::SORT_ORDER_ASC);

        /* @var Tree $tree Item model tree */
        $tree = $this->treeFactory->create();
        $rootNode = $tree->addNode(new Node(['id' => 0], 'id', $tree));
        foreach ($itemCollection as $item) {
            /* @var $item Item */
            if ($tree->getNodeById($item->getId()) === null) {
                $tree->appendChild(
                    array_merge($item->getData(), ['renderer' => $item->getRenderer()]),
                    $this->getParentNode($tree, $itemCollection, $item->getData('parent_id'))
                );
            }
        }

        $itemBlocks = [];
        foreach ($rootNode->getChildren() as $node) {
            /* @var $renderer AbstractRenderer */
            $renderer = $this->layout->createBlock(
                $node->getData('renderer'),
                'menu_item_renderer_' . $node->getData('id'),
                ['data' => ['node' => $node, 'level' => 0]]
            );
            foreach ($renderer->getItemBlocks() as $itemBlock) {
                $itemBlocks[] = $itemBlock;
            }
        }
        return $itemBlocks;
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
            $parentNode = $tree->appendChild(
                array_merge($parentItem->getData(), ['renderer' => $parentItem->getRenderer()]),
                $this->getParentNode($tree, $itemCollection, $parentItem->getData('parent_id'))
            );
        }
        return $parentNode;
    }
}
