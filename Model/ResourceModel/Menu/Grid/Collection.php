<?php

namespace Common\Menu\Model\ResourceModel\Menu\Grid;

use Common\Base\Model\ResourceModel\Grid\AbstractCollection;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Common\Menu\Model\ResourceModel\Menu\Collection as MenuCollection;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;

class Collection extends MenuCollection implements SearchResultInterface
{
    use AbstractCollection;

    /**
     * @var string
     */
    protected $_eventPrefix = 'menu_menu_grid_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Document::class, ResourceMenu::class);
    }
}
