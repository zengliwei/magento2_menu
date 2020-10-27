<?php

namespace Common\Menu\Block\Menu\Item\Renderer;

use Common\Menu\Block\Menu\Item;
use Magento\Framework\Data\Tree\Node;

class DefaultRenderer extends AbstractRenderer
{
    /**
     * @inheritDoc
     */
    protected function buildItemBlocks()
    {
        /* @var $node Node */
        $node = $this->getData('node');

        $url = preg_match('/^https?:\/\//', $node->getData('url'))
            ? $node->getData('url')
            : $this->_urlBuilder->getBaseUrl() . trim($node->getData('url'), '/');

        $children = [];
        foreach ($node->getChildren() as $child) {
            /* @var $renderer AbstractRenderer */
            $renderer = $this->getLayout()->createBlock(
                $child->getData('renderer'),
                'menu_item_renderer_' . $child->getData('id'),
                ['data' => ['node' => $child, 'level' => $this->getData('level') + 1]]
            );
            foreach ($renderer->getItemBlocks() as $itemBlock) {
                $children[] = $itemBlock;
            }
        }

        $this->itemBlocks = [
            $this->getLayout()->createBlock(
                Item::class,
                '',
                [
                    'data' => [
                        'title'    => $node->getData('title'),
                        'url'      => $url,
                        'level'    => $this->getData('level'),
                        'children' => $children
                    ]
                ]
            )
        ];
    }
}
