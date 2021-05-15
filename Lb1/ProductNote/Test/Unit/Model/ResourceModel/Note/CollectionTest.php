<?php
namespace Lb1\ProductNote\Test\Unit\Model\ResourceModel\Note;

use Lb1\ProductNote\Test\Unit\Model\ResourceModel\AbstractCollectionTest;
use Magento\Framework\DataObject;

class CollectionTest extends AbstractCollectionTest
{
    /**
     * @var \Lb1\ProductNote\Model\ResourceModel\Note\Collection
     */
    protected $collection;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->collection = $this->objectManager->getObject(
            \Lb1\ProductNote\Model\ResourceModel\Note\Collection::class,
            [
                'resource' => $this->resource,
                'connection' => $this->connection,
            ]
        );
    }

    public function testAddCustomerFilter()
    {
        $customerId = 1;
        $expectedFilter = new DataObject(
            [
                'field' => 'customer_id',
                'value' => $customerId,
                'type' => 'and'
            ]
        );
        $this->assertSame($this->collection, $this->collection->addCustomerFilter($customerId));
        $this->assertEquals($expectedFilter, $this->collection->getFilter('customer_id'));
    }

    public function testAddStoreFilter()
    {
        $storeId = 1;
        $expectedFilter = new DataObject(
            [
                'field' => 'main_table.store_id',
                'value' => $storeId,
                'type' => 'and'
            ]
        );
        $this->assertSame($this->collection, $this->collection->addStoreFilter($storeId));
        $this->assertEquals($expectedFilter, $this->collection->getFilter('main_table.store_id'));
    }

    public function testAddProductFilter()
    {
        $productId = 1;
        $expectedFilter = new DataObject(
            [
                'field' => 'main_table.product_id',
                'value' => $productId,
                'type' => 'and'
            ]
        );
        $this->assertSame($this->collection, $this->collection->addProductFilter($productId));
        $this->assertEquals($expectedFilter, $this->collection->getFilter('main_table.product_id'));
    }

    /**
     * @return array
     */
    public function getItemsDataProvider()
    {
        return [
            [
                new \Magento\Framework\DataObject(['id' => 1, 'row_id' => 1]),
                [
                    ['row_id' => 1, 'store_id' => \Magento\Store\Model\Store::DEFAULT_STORE_ID],
                ],
            ],
            [
                new \Magento\Framework\DataObject(['id' => 2, 'row_id' => 2]),
                [
                    ['row_id' => 2, 'store_id' => 1],
                    ['row_id' => 2, 'store_id' => 2],
                ],
            ],
        ];
    }
}
