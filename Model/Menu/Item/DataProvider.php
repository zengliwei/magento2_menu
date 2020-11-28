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

namespace Common\Menu\Model\Menu\Item;

use Common\Base\Model\AbstractDataProvider;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection;
use Common\Menu\Ui\Component\Menu\Item\FunctionalUrls;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends AbstractDataProvider
{
    protected $persistKey = 'menu_item';

    /**
     * @var array
     */
    protected $functionalUrls;

    /**
     * @var Type
     */
    protected $itemType;

    /**
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param FunctionalUrls         $functionalUrls
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface  $storeManager
     * @param Filesystem             $filesystem
     * @param ObjectManagerInterface $objectManager
     * @param Type                   $itemType
     * @param array                  $meta
     * @param array                  $data
     * @param PoolInterface|null     $pool
     * @throws FileSystemException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        FunctionalUrls $functionalUrls,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        ObjectManagerInterface $objectManager,
        Type $itemType,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->functionalUrls = $functionalUrls;
        $this->itemType = $itemType;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $dataPersistor,
            $storeManager,
            $filesystem,
            $objectManager,
            $meta,
            $data,
            $pool
        );
    }

    /**
     * @inheritDoc
     */
    public function getMeta()
    {
        $this->meta = ['general' => ['children' => []]];
        $this->customizeTypes();
        $this->customizeFunctionalUrls();
        return parent::getMeta();
    }

    /**
     * @return void
     */
    protected function customizeTypes()
    {
        $rules = [
            [
                'value'   => 'default',
                'actions' => [
                    ['target' => 'menu_item_form.menu_item_form.general.url', 'callback' => 'show'],
                    ['target' => 'menu_item_form.menu_item_form.general.functional_urls', 'callback' => 'show'],
                    [
                        'target'   => 'menu_item_form.menu_item_form.general.functional_urls',
                        'callback' => 'value',
                        'params'   => [0]
                    ]
                ]
            ]
        ];
        foreach ($this->itemType->getTypes() as $type) {
            if ($type['name'] != 'default') {
                $rules[] = [
                    'value'   => $type['name'],
                    'actions' => [
                        ['target' => 'menu_item_form.menu_item_form.general.url', 'callback' => 'hide'],
                        ['target' => 'menu_item_form.menu_item_form.general.functional_urls', 'callback' => 'hide']
                    ]
                ];
            }
        }
        $this->meta['general']['children']['type'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'switcherConfig' => [
                            'enabled' => true,
                            'rules'   => $rules
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @return void
     */
    protected function customizeFunctionalUrls()
    {
        $rules = [];
        foreach ($this->functionalUrls->getUrls() as $urls) {
            foreach ($urls as $url) {
                $rules[] = [
                    'value'   => $url,
                    'actions' => [
                        [
                            'target'   => 'menu_item_form.menu_item_form.general.url',
                            'callback' => 'value',
                            'params'   => [$url]
                        ]
                    ]
                ];
            }
        }
        $this->meta['general']['children']['functional_urls'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'switcherConfig' => [
                            'enabled' => true,
                            'rules'   => $rules
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->initCollection(Collection::class);
    }
}
