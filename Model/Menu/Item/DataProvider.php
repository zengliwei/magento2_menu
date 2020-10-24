<?php

namespace Common\Menu\Model\Menu\Item;

use Common\Base\Model\AbstractDataProvider;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection;

class DataProvider extends AbstractDataProvider
{
    protected $persistKey = 'menu_item';

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->initCollection(Collection::class);
    }
}
