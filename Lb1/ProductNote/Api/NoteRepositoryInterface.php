<?php
namespace Lb1\ProductNote\Api;

use Lb1\ProductNote\Api\Data\NoteInterface;
use Lb1\ProductNote\Api\Data\NoteSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface NoteRepositoryInterface
{
    /**
     * Save note.
     *
     * @param NoteInterface $note
     * @return NoteInterface
     * @throws CouldNotSaveException
     */
    public function save(NoteInterface $note): NoteInterface;

    /**
     * Get note by note id.
     *
     * @param int $noteId
     * @return NoteInterface
     * @throws LocalizedException
     */
    public function getById(int $noteId): NoteInterface;

    /**
     * Delete note.
     *
     * @param NoteInterface $note
     * @return bool
     * @throws NoSuchEntityException
     */
    public function delete(NoteInterface $note): bool;

    /**
     * Delete note by id.
     *
     * @param int $noteId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById(int $noteId): bool;

    /**
     * Get note search results.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return NoteSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): NoteSearchResultsInterface;
}
