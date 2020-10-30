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
namespace Common\Menu\Controller\Adminhtml\Item;

use Common\Base\Controller\Adminhtml\AbstractEditAction;
use Common\Menu\Model\Menu\Item;

class Edit extends AbstractEditAction
{
    public const ADMIN_RESOURCE = 'Common_Menu::menu_item';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->render(
            Item::class,
            'Specified item does not exist.',
            'Common_Menu::menu_item',
            'Create Menu Item',
            'Edit Menu Item (ID: %1)'
        );
    }
}
