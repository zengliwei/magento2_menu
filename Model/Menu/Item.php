<?php

namespace Common\Menu\Model\Menu;

use Common\Base\Model\AbstractStoreModel;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Item extends AbstractStoreModel
{
    /**
     * @var Item\Type
     */
    protected $type;

    /**
     * @param Item\Type             $type
     * @param Context               $context
     * @param Registry              $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null       $resourceCollection
     * @param array                 $data
     */
    public function __construct(
        Item\Type $type,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->type = $type;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(\Common\Menu\Model\ResourceModel\Menu\Item::class);
    }

    /**
     * @return string|null
     */
    public function getRenderer()
    {
        $typeInfo = $this->type->getType($this->getData('type'));
        return $typeInfo['renderer'] ?? null;
    }
}
