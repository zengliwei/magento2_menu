<?php

namespace Common\Menu\Block;

use Common\Menu\Model\Menu as Model;
use Common\Menu\Model\MenuFactory;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Menu extends Template
{
    public const CACHE_KEY_PREFIX = 'MENU_BLOCK_';

    /**
     * @var Model
     */
    private $menu;

    /**
     * @var MenuFactory
     */
    private $menuFactory;

    /**
     * @var ResourceMenu
     */
    private $resourceMenu;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param MenuFactory           $menuFactory
     * @param ResourceMenu          $resourceMenu
     * @param StoreManagerInterface $storeManager
     * @param Context               $context
     * @param array                 $data
     */
    public function __construct(
        MenuFactory $menuFactory,
        ResourceMenu $resourceMenu,
        StoreManagerInterface $storeManager,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->menuFactory = $menuFactory;
        $this->resourceMenu = $resourceMenu;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if ($this->getMenu()->getItems() === null) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     * @return Model
     */
    public function getMenu()
    {
        if ($this->menu === null) {
            $this->menu = $this->menuFactory->create();
            if ($this->getData('identifier')) {
                $this->resourceMenu->load($this->menu, $this->getData('identifier'), 'identifier');
            }
        }
        return $this->menu;
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getMenuItemHtml()
    {
        $html = '';
        foreach ($this->getMenu()->getItems() as $item) {
            /* @var $itemBlock Menu\Item */
            $itemBlock = $this->getLayout()->createBlock(
                Menu\Item::class,
                '',
                [
                    'data' => ['item' => $item]
                ]
            );
            $html .= $itemBlock->toHtml();
        }
        return $html;
    }
}
