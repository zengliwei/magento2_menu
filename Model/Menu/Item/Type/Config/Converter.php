<?php

namespace Common\Menu\Model\Menu\Item\Type\Config;

use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convert($source)
    {
        $output = [];
        foreach ($source->getElementsByTagName('type') as $typeNode) {
            $output[] = [
                'name'       => $typeNode->attributes->getNamedItem('name')->value,
                'label'      => $typeNode->attributes->getNamedItem('label')->value,
                'sort_order' => $typeNode->attributes->getNamedItem('sort_order')->value,
                'renderer'   => $typeNode->attributes->getNamedItem('renderer')->value
            ];
        }
        usort(
            $output,
            function ($a, $b) {
                $a['sort_order'] > $b['sort_order'] ? 1 : ($a['sort_order'] < $b['sort_order'] ? -1 : 0);
            }
        );
        return $output;
    }
}
