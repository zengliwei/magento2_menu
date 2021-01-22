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
use Common\Menu\Model\Menu\Item as ItemModel;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\View\Element\AbstractBlock;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
abstract class AbstractRenderer extends AbstractBlock
{
    /**
     * @var CustomerSession
     */
    protected CustomerSession $customerSession;

    /**
     * @var Item[]
     */
    protected $itemBlocks;

    /**
     * @param Context $context
     * @param array   $data
     */
    public function __construct(Context $context, array $data = [])
    {
        $this->customerSession = $context->getCustomerSession();
        parent::__construct($context, $data);
    }

    /**
     * @return Item[]
     */
    public function getItemBlocks()
    {
        if ($this->itemBlocks === null) {
            /* @var $node Node */
            $node = $this->getData('node');
            switch ($node->getData('visibility')) {
                case ItemModel::VISIBILITY_ALL:
                    $this->buildItemBlocks();
                    break;

                case ItemModel::VISIBILITY_GUEST:
                    if ($this->customerSession->isLoggedIn()) {
                        $this->itemBlocks = [];
                    } else {
                        $this->buildItemBlocks();
                    }
                    break;

                case ItemModel::VISIBILITY_LOGGED_IN:
                    if ($this->customerSession->isLoggedIn()) {
                        $this->buildItemBlocks();
                    } else {
                        $this->itemBlocks = [];
                    }
                    break;
            }
        }
        return $this->itemBlocks;
    }

    /**
     * @return void
     */
    abstract protected function buildItemBlocks();
}
