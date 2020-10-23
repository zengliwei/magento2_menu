<?php

namespace Common\Menu\Model\ResourceModel\Menu;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class Item extends AbstractDb
{
    /**
     * @var null|Store
     */
    protected $store = null;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Context               $context
     * @param string|null           $connectionName
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);

        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init('menu_item', 'id');
    }

    /**
     * @return Store
     * @throws NoSuchEntityException
     */
    public function getStore()
    {
        return $this->storeManager->getStore($this->store);
    }
}
