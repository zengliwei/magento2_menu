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

namespace Common\Menu\Ui\Component\Menu\Item;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_banner
 */
class FunctionalUrls implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $urls = [];

    /**
     * @param array $urls
     */
    public function __construct(array $urls = [])
    {
        $this->urls = $urls;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [['label' => __('Select a functional URL'), 'value' => '']];
        foreach ($this->urls as $groupName => $urls) {
            $groupOptions = [];
            foreach ($urls as $url) {
                $groupOptions[] = ['label' => $url, 'value' => $url];
            }
            $options[] = ['label' => $groupName, 'value' => $groupOptions];
        }
        return $options;
    }
}
