<?php

namespace Common\Menu\Model\Menu;

use Common\Base\Model\AbstractDataProvider;
use Common\Menu\Model\ResourceModel\Menu\Collection;

class DataProvider extends AbstractDataProvider
{
    protected $persistKey = 'menu_menu';

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->initCollection(Collection::class);
    }
}
