<?php

namespace Common\Menu\Block\Menu;

use Magento\Framework\View\Element\AbstractBlock;

class Item extends AbstractBlock
{
    public function toHtml()
    {
        $item = $this->getData('item');
        if (!($item instanceof \Common\Menu\Model\Menu\Item)) {
            return '';
        }
        if ($item->getRenderer()) {
            return $this->_layout->createBlock(
                $item->getRenderer(),
                '',
                [
                    'data' => ['item' => $item]
                ]
            )->toHtml();
        }
        return '';
    }
}
