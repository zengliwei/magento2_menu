<?php

namespace Common\Menu\Ui\Component\Menu\Item;

use Common\Menu\Model\ResourceModel\Menu\Item\Collection;
use Common\Menu\Model\ResourceModel\Menu\Item\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param array $itemGroups
     * @param int   $parentId
     * @param int   $level
     * @return array
     */
    protected function collectOptions($itemGroups, $parentId = 0, $level = 0)
    {
        $options = [];
        if (isset($itemGroups[$parentId])) {
            $level++;
            $spaceString = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');
            foreach ($itemGroups[$parentId] as $item) {
                $options[] = [
                    'label' => sprintf(
                        '%s%s (ID: %d)',
                        str_repeat($spaceString, $level * 4),
                        $item->getData('title'),
                        $item->getId()
                    ),
                    'value' => $item->getId()
                ];
                if (isset($itemGroups[$parentId])) {
                    $options = array_merge($options, $this->collectOptions($itemGroups, $item->getId(), $level));
                }
            }
        }
        return $options;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            /* @var $itemCollection Collection */
            $itemCollection = $this->collectionFactory->create();
            $itemCollection->addOrder('main_table.order', Collection::SORT_ORDER_ASC);
            $itemGroups = [];
            foreach ($itemCollection as $item) {
                if (!isset($itemGroups[$item->getData('parent_id')])) {
                    $itemGroups[$item->getData('parent_id')] = [];
                }
                $itemGroups[$item->getData('parent_id')][] = $item;
            }
            $this->options = array_merge(
                [['label' => '[ root ]', 'value' => 0]],
                $this->collectOptions($itemGroups)
            );
        }
        return $this->options;
    }
}
