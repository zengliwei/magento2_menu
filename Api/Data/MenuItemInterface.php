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

namespace Common\Menu\Api\Data;

/**
 * @api
 */
interface MenuItemInterface
{
    public const CHILDREN = 'children';
    public const FIELD_CLASS = 'class';
    public const FIELD_LEVEL = 'level';
    public const FIELD_LINK = 'url';
    public const FIELD_TARGET = 'target';
    public const FIELD_TITLE = 'title';

    /**
     * @return \Common\Menu\Api\Data\MenuItemInterface[]
     */
    public function getChildren();

    /**
     * @return string
     */
    public function getClass();

    /**
     * @return int
     */
    public function getLevel();

    /**
     * @return string
     */
    public function getLink();

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getTitle();
}
