<?php
namespace Lb1\ProductNote\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface NoteSearchResultsInterface
    extends SearchResultsInterface
{
    /**
     * Get note array.
     *
     * @return  NoteInterface[]
     */
    public function getItems();

    /**
     * Set note array.
     *
     * @param array $items
     * @return NoteSearchResultsInterface
     */
    public function setItems(array $items);
}
