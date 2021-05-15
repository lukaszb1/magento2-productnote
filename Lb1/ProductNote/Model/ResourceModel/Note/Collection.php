<?php namespace Lb1\ProductNote\Model\ResourceModel\Note;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection
    extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'note_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'lb1_productnote_note';

    /**
     * @var string
     */
    protected $_eventObject = 'lb1_productnote_note_collection';

    /**
     * @inheriDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Lb1\ProductNote\Model\Note::class,
            \Lb1\ProductNote\Model\ResourceModel\Note::class
        );
    }

    /**
     * Filter by customer id.
     *
     * @param int $customerId
     * @return $this
     */
    public function addCustomerFilter(int $customerId): self
    {
        $this->addFilter('customer_id', $customerId);
        return $this;
    }

    /**
     * Filter by store id.
     *
     * @param int $storeId
     * @return $this
     */
    public function addStoreFilter(int $storeId): self
    {
        $this->addFilter('main_table.store_id', $storeId);
        return $this;
    }

    /**
     * Filter by product id.
     *
     * @param int $productId
     * @return $this
     */
    public function addProductFilter(int $productId): self
    {
        $this->addFilter('main_table.product_id', $productId);
        return $this;
    }

    /**
     * Order by created date.
     * 
     * @return Collection
     */
    public function setCreatedAtOrder()
    {
        return $this->setOrder('created_at', self::SORT_ORDER_DESC);
    }

    /**
     * @return $this
     */
    public function joinCustomerName(): self
    {
        $this->getSelect()->joinLeft(
            ['ce' => $this->getTable('customer_entity')],
            'main_table.customer_id = ce.entity_id',
            ['firstname']
        );
        return $this;
    }
}
