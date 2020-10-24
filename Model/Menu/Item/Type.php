<?php

namespace Common\Menu\Model\Menu\Item;

class Type
{
    /**
     * @var Type\Config
     */
    protected $config;

    /**
     * @var string[]
     */
    protected $types;

    /**
     * @param Type\Config $config
     */
    public function __construct(Type\Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        if ($this->types === null) {
            $menuItemTypes = $this->config->getAll();
            foreach ($menuItemTypes as &$info) {
                $info['label'] = __($info['label']);
            }
            $this->types = $menuItemTypes;
        }
        return $this->types;
    }
}
