<?php

namespace Common\Menu\Model\Menu\Item;

use Common\Base\Model\AbstractDataProvider;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection;
use Common\Menu\Ui\Component\Menu\Item\FunctionalUrls;
use Magento\Framework\App\Request\DataPersistorInterface;
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
     * @param Type                   $itemType
     * @param array                  $meta
     * @param array                  $data
     * @param PoolInterface|null     $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        FunctionalUrls $functionalUrls,
        DataPersistorInterface $dataPersistor,
        Type $itemType,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $dataPersistor, $meta, $data, $pool);

        $this->functionalUrls = $functionalUrls;
        $this->itemType = $itemType;
    }

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->initCollection(Collection::class);
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
    public function getMeta()
    {
        $this->meta = ['general' => ['children' => []]];
        $this->customizeTypes();
        $this->customizeFunctionalUrls();
        return parent::getMeta();
    }
}
