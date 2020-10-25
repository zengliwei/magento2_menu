<?php

namespace Common\Menu\Block\Menu\Item\Renderer;

use Magento\Catalog\Plugin\Block\Topmenu;
use Magento\Framework\View\Element\Template;

class CatalogCategoryTree extends Template
{
    protected $_template = 'Common_Menu::menu/item/renderer/catalog_category_tree.phtml';

    /**
     * @var Topmenu
     */
    protected $processor;

    public function __construct(
        Topmenu $processor,
        Template\Context $context,
        array $data = []
    ) {
        $this->processor = $processor;
        parent::__construct($context, $data);
    }

    public function getCategoryTree()
    {
        return Closure::bind(
            function () {
                $rootId = $this->storeManager->getStore()->getRootCategoryId();
                $storeId = $this->storeManager->getStore()->getId();
                return $this->getCategoryTree($storeId, $rootId);
            },
            $this->processor
        );
    }

    public function getCurrentCategory()
    {
        return Closure::bind(
            function () {
                return $this->getCurrentCategory();
            },
            $this->processor
        );
    }
}
