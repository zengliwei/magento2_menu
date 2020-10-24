<?php

namespace Common\Menu\Model\ResourceModel\Menu\Item;

use Common\Base\Model\ResourceModel\AbstractStoreCollection;
use Common\Menu\Model\Menu\Item;
use Common\Menu\Model\ResourceModel\Menu\Item as ResourceItem;

class Collection extends AbstractStoreCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'menu_item_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Item::class, ResourceItem::class);
    }
}
