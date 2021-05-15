<?php

namespace Lb1\ProductNote\ViewModel;

use Lb1\ProductNote\Model\ResourceModel\Note\Collection;
use Lb1\ProductNote\Model\ResourceModel\Note\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\SessionFactory;

class ListingViewModel
    implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CollectionFactory
     */
    protected $noteCollectionFactory;

    /**
     * @var SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @param RequestInterface $request
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        SessionFactory $customerSessionFactory
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->noteCollectionFactory = $collectionFactory;
        $this->customerSessionFactory = $customerSessionFactory;
    }

    /**
     * Returns current product id.
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int)$this->request->getParam('id');
    }

    /**
     * Returns current customer id.
     * 
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int)$this->customerSessionFactory->create()->getCustomerId();
    }

    /**
     * Returns note collection.
     *
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getNotes(): Collection
    {
        return $this->noteCollectionFactory->create()->joinCustomerName()->addStoreFilter($this->storeManager->getStore()->getId())
            ->addProductFilter($this->getProductId())->addCustomerFilter($this->getCustomerId())->setCreatedAtOrder();
    }
}
