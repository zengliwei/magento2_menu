<?php
/*
 * Copyright (c) 2020 Zengliwei
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Common\Menu\Block;

use Common\Menu\Helper\Menu as MenuHelper;
use Common\Menu\Model\Menu as Model;
use Common\Menu\Model\MenuFactory;
use Common\Menu\Model\ResourceModel\Menu as ResourceMenu;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
class Menu extends Template
{
    public const CACHE_KEY_PREFIX = 'MENU_BLOCK_';

    /**
     * @var Model
     */
    protected $menu;

    /**
     * @var MenuFactory
     */
    protected MenuFactory $menuFactory;

    /**
     * @var MenuHelper
     */
    protected MenuHelper $menuHelper;

    /**
     * @var ResourceMenu
     */
    protected ResourceMenu $resourceMenu;

    /**
     * @param MenuFactory  $menuFactory
     * @param MenuHelper   $menuHelper
     * @param ResourceMenu $resourceMenu
     * @param Context      $context
     * @param array        $data
     */
    public function __construct(
        MenuFactory $menuFactory,
        MenuHelper $menuHelper,
        ResourceMenu $resourceMenu,
        Context $context,
        array $data = []
    ) {
        $this->menuFactory = $menuFactory;
        $this->menuHelper = $menuHelper;
        $this->resourceMenu = $resourceMenu;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMenuItemHtml()
    {
        $html = '';
        foreach ($this->menuHelper->getItemTree($this->getMenu()->getId()) as $item) {
            $html .= $item->toHtml();
        }
        return $html;
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
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if (!$this->getMenu()->getId()) {
            return '';
        }
        return parent::_toHtml();
    }
}
