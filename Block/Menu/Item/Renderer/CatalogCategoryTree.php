<?php

namespace Common\Menu\Block\Menu\Item\Renderer;

use Common\Menu\Block\Menu\Item;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\Tree;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\StoreManagerInterface;

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
                        'class'    => 'category-item',
                        'level'    => $level,
                        'children' => $this->collectBlocks($child, $level + 1)
                    ]
                ]
            );
        }
        return $blocks;
    }

    /**
     * @param Category $category
     * @return Item[]
     */
    protected function getCategoryData($category)
    {
        return [
            'id'        => $category->getId(),
            'name'      => $category->getData('name'),
            'url'       => $category->getUrl(),
            'parent_id' => $category->getParentId()
        ];
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
            $parentData = $this->getCategoryData($collection->getItemById($parentId));
            $parentNode = $tree->appendChild(
                $parentData,
                $this->getParentNode($tree, $collection, $parentData['parent_id'])
            );
        }
        return $parentNode;
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
            $tree->appendChild($this->getCategoryData($category), $parentNode);
        }

        $this->itemBlocks = $this->collectBlocks($rootNode, $this->getData('level'));
    }
}
