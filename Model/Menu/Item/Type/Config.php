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
namespace Common\Menu\Model\Menu\Item\Type;

use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Config\Data;
use Magento\Framework\Serialize\SerializerInterface;

class Config extends Data
{
    /**
     * @param Config\Reader            $reader
     * @param CacheInterface           $cache
     * @param string|null              $cacheId
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        Config\Reader $reader,
        CacheInterface $cache,
        $cacheId = 'menu_item_types_config',
        SerializerInterface $serializer = null
    ) {
        parent::__construct($reader, $cache, $cacheId, $serializer);
    }

    /**
     * @param string $name
     * @return array
     */
    public function getType($name)
    {
        return $this->get($name, []);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->get(null, []);
    }
}
