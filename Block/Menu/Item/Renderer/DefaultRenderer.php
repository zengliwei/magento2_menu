<?php

namespace Common\Menu\Block\Menu\Item\Renderer;

use Common\Menu\Model\Menu\Item;
use Magento\Framework\View\Element\Template;

class DefaultRenderer extends Template
{
    protected $_template = 'Common_Menu::menu/item/renderer/default.phtml';

    /**
     * @return array
     */
    public function getItem()
    {
        /* @var $item Item */
        $item = $this->getData('item');

        $url = preg_match('/^https?:\/\//', $item->getData('title'))
            ? $item->getData('title')
            : $this->_urlBuilder->getUrl();

        return [
            'title' => $item->getData('title'),
            'url'   => $url
        ];
    }
}
