<?php
/*
 * Copyright (c) 2020 Zengliwei
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
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
