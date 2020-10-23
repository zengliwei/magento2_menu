<?php

namespace Common\Menu\Model\ResourceModel\Menu\Item\Grid;

use Common\Menu\Model\ResourceModel\Menu\Item as ResourceItem;
use Common\Menu\Model\ResourceModel\Menu\Item\Collection as ItemCollection;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;

class Collection extends ItemCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected AggregationInterface $aggregations;

    /**
     * @var string
     */
    protected string $_eventPrefix = 'menu_item_grid_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Document::class, ResourceItem::class);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return Collection
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param ExtensibleDataInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
