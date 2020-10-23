<?php

namespace Common\Menu\Model\ResourceModel\Menu;

use Common\Menu\Model\Menu;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected string $_idFieldName = 'id';

    /**
     * @var string
     */
    protected string $_eventPrefix = 'menu_menu_collection';

    /**
     * @var string
     */
    protected string $_eventObject = 'collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Menu::class, ResourceMenu::class);
    }
}
