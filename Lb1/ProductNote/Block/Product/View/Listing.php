<?php

namespace Lb1\ProductNote\Block\Product\View;

use Lb1\ProductNote\Model\ResourceModel\Note\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\Pager;

/**
 * @method \Lb1\ProductNote\ViewModel\ListingViewModel getViewModel()
 */
class Listing
    extends Template
{
    /**
     * Toolbar settings
     */
    const PAGE_VAR_NAME = 'note_page';
    const PAGE_SIZE_VAR_NAME = 'note_limit';

    /**
     * Prepare notes list toolbar.
     *
     * @return $this
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout(): self
    {
        parent::_prepareLayout();

        /** @var Pager $toolbar */
        $toolbar = $this->getChildBlock('product.details.notes.listing.toolbar');
        if ($toolbar) {
            $toolbar->setLimitVarName(self::PAGE_SIZE_VAR_NAME);
            $toolbar->setPageVarName(self::PAGE_VAR_NAME);
            $toolbar->setShowAmounts(false);
            $toolbar->setCollection($this->getNotes());
        }
        return $this;
    }

    /**
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getNotes(): Collection
    {
        $page = (int)$this->getRequest()->getParam(static::PAGE_VAR_NAME, 1);
        $limit = (int)$this->getRequest()->getParam(static::PAGE_SIZE_VAR_NAME, 10);

        $collection = $this->getViewModel()->getNotes();
        $collection->setCurPage($page);
        $collection->setPageSize($limit);
        return $collection;
    }
}
