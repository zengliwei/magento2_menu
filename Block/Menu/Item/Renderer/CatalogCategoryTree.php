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

namespace Common\Menu\Block\Menu\Item\Renderer;

use Common\Menu\Block\Menu\Item;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\Tree;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
class CatalogCategoryTree extends AbstractRenderer
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TreeFactory
     */
    protected $treeFactory;

    /**
     * @param CollectionFactory     $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param TreeFactory           $treeFactory
     * @param Context               $context
     * @param array                 $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        TreeFactory $treeFactory,
        Context $context,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->treeFactory = $treeFactory;

        parent::__construct($context, $data);
    }

    /**
     * @inheritDoc
     */
    protected function buildItemBlocks()
    {
        $rootId = $this->storeManager->getStore()->getRootCategoryId();
        $storeId = $this->storeManager->getStore()->getId();

        /* @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->setStoreId($storeId)
            ->addAttributeToSelect('name')
            ->addFieldToFilter('path', ['like' => '1/' . $rootId . '/%'])
            ->addAttributeToFilter('include_in_menu', 1)
            ->addIsActiveFilter()
            ->addNavigationMaxDepthFilter()
            ->addUrlRewriteToResult()
            ->addOrder('level', Collection::SORT_ORDER_ASC)
            ->addOrder('position', Collection::SORT_ORDER_ASC)
            ->addOrder('parent_id', Collection::SORT_ORDER_ASC)
            ->addOrder('entity_id', Collection::SORT_ORDER_ASC);

        /* @var $tree Tree */
        $tree = $this->treeFactory->create();
        $rootNode = new Node(['id' => $rootId], 'id', $tree);
        $tree->addNode($rootNode);
        foreach ($collection as $category) {
            $parentNode = $this->getParentNode($tree, $collection, $category->getData('parent_id'));
            $nodeData = $this->getNodeData($category);
            $tree->appendChild($this->getNodeData($category), $parentNode);
        }

        $this->itemBlocks = $this->collectBlocks($rootNode, $this->getData('level'));
    }

    /**
     * @param Tree               $tree
     * @param AbstractCollection $collection
     * @param int                $parentId
     * @return Node
     */
    protected function getParentNode($tree, $collection, $parentId)
    {
        if (($parentNode = $tree->getNodeById($parentId)) === null) {
            $parentData = $this->getNodeData($collection->getItemById($parentId));
            $parentNode = $tree->appendChild(
                $parentData,
                $this->getParentNode($tree, $collection, $parentData['parent_id'])
            );
        }
        return $parentNode;
    }

    /**
     * @param Category $category
     * @return Item[]
     */
    protected function getNodeData($category)
    {
        return [
            'id'        => $category->getId(),
            'name'      => $category->getData('name'),
            'url'       => $category->getUrl(),
            'target'    => $this->getData('node')->getData('target'),
            'parent_id' => $category->getParentId()
        ];
    }

    /**
     * @param Node $node
     * @param int  $level
     * @return Item[]
     * @throws LocalizedException
     */
    protected function collectBlocks($node, $level)
    {
        $blocks = [];
        foreach ($node->getChildren() as $child) {
            $blocks[] = $this->getLayout()->createBlock(
                Item::class,
                '',
                [
                    'data' => [
                        'title'    => $child->getData('name'),
                        'url'      => $child->getData('url'),
                        'target'   => $child->getData('target'),
                        'class'    => 'category-item',
                        'level'    => $level,
                        'children' => $this->collectBlocks($child, $level + 1)
                    ]
                ]
            );
        }
        return $blocks;
    }
}
