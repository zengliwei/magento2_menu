<?php

namespace Common\Menu\Model;

use Common\Menu\Model\ResourceModel\Menu\Item;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection as ItemCollection;
use Common\Menu\Model\ResourceModel\Menu\Item\CollectionFactory as ItemCollectionFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Menu extends AbstractModel
{
    /**
     * @var ItemCollectionFactory
     */
    protected $itemCollectionFactory;

    public function __construct(
        ItemCollectionFactory $itemCollectionFactory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->itemCollectionFactory = $itemCollectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Menu::class);
    }

    /**
     * @return Item[]|null
     */
    public function getItems()
    {
        if ($this->getData('items') === null
            && $this->getId()
        ) {
            /* @var $itemCollection ItemCollection */
            $itemCollection = $this->itemCollectionFactory->create();
            $itemCollection->addFieldToFilter('menu_id', ['eq' => $this->getId()]);
            $items = $itemCollection->getItems();
            foreach ($items as $item) {
                $item->setData('menu', $this);
            }
            $this->setData('items', $items);
        }
        return $this->getData('items');
    }
}
