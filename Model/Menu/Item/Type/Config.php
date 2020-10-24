<?php

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
