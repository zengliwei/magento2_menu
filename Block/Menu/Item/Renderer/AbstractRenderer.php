<?php

namespace Common\Menu\Block\Menu\Item\Renderer;

use Common\Menu\Block\Menu\Item;
use Magento\Framework\View\Element\AbstractBlock;

abstract class AbstractRenderer extends AbstractBlock
{
    /**
     * @var Item[]
     */
    protected $itemBlocks;

    /**
     * @return Item[]
     */
    public function getItemBlocks()
    {
        if ($this->itemBlocks === null) {
            $this->buildItemBlocks();
        }
        return $this->itemBlocks;
    }

    /**
     * @return void
     */
    abstract protected function buildItemBlocks();
}
