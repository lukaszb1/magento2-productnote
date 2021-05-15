<?php

namespace Lb1\ProductNote\Plugin;

use Lb1\ProductNote\Ui\DataProvider\Note\ListingDataProvider;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddAttributesToUiDataProvider
{
    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get Search Result after plugin
     *
     * @param ListingDataProvider $subject
     * @param SearchResult $result
     * @return SearchResult
     */
    public function afterGetSearchResult(ListingDataProvider $subject, SearchResult $result): SearchResult
    {
        if ($result->isLoaded()) {
            return $result;
        }
        $result->getSelect()->joinLeft(
            ['ce' => $this->resource->getTableName('customer_entity')],
            'main_table.customer_id = ce.entity_id',
            ['firstname']
        );
        return $result;
    }
}
