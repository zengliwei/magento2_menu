<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractMassSaveAction;
use Common\Menu\Model\Menu\Item;

class MassSave extends AbstractMassSaveAction
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->save(Item::class);
    }
}
