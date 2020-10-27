<?php

namespace Common\Menu\Ui\Component\Menu\Item;

use Magento\Framework\Data\OptionSourceInterface;

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
