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
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param FunctionalUrls         $functionalUrls
     * @param DataPersistorInterface $dataPersistor
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
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $dataPersistor, $meta, $data, $pool);

        $this->functionalUrls = $functionalUrls;
    }

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->initCollection(Collection::class);
    }

    protected function customizeFunctionalUrl()
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

        $this->meta = [
            'general' => [
                'children' => [
                    'functional_urls' => [
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
        $this->customizeFunctionalUrl();
        return parent::getMeta();
    }
}
