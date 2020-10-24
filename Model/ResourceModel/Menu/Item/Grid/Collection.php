<?php

namespace Common\Menu\Model\ResourceModel\Menu\Item\Grid;

use Common\Base\Model\ResourceModel\Grid\AbstractCollection;
use Common\Menu\Model\ResourceModel\Menu\Item as ResourceItem;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection as ItemCollection;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;

class Collection extends ItemCollection implements SearchResultInterface
{
    use AbstractCollection;

    /**
     * @var string
     */
    protected $_eventPrefix = 'menu_item_grid_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Document::class, ResourceItem::class);
    }
}
