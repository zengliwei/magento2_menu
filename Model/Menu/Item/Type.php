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
            $types = [];
            foreach ($this->config->getAll() as $info) {
                $info['label'] = __($info['label']);
                $types[$info['name']] = $info;
            }
            $this->types = $types;
        }
        return $this->types;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getType($name)
    {
        $this->getTypes();
        return $this->types[$name] ?? null;
    }
}
