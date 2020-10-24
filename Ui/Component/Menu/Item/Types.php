<?php

namespace Common\Menu\Ui\Component\Menu\Item;

use Common\Menu\Model\Menu\Item\Type;
use Magento\Framework\Data\OptionSourceInterface;

class Types implements OptionSourceInterface
{
    /**
     * @var Type
     */
    private $type;

    /**
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->type->getTypes() as $key => $info) {
            $options[] = [
                'value' => $info['name'],
                'label' => $info['label']
            ];
        }
        return $options;
    }
}
