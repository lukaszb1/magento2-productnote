<?php
namespace Lb1\ProductNote\Model;

use Lb1\ProductNote\Api\Data;
use Lb1\ProductNote\Api\Data\NoteInterface;
use Lb1\ProductNote\Api\Data\NoteSearchResultsInterface;
use Lb1\ProductNote\Model\ResourceModel\Note as ResourceNote;
use Lb1\ProductNote\Model\ResourceModel\Note\CollectionFactory as NoteCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NoteRepository
    implements \Lb1\ProductNote\Api\NoteRepositoryInterface
{
    /**
     * @var ResourceNote
     */
    protected $resource;

    /**
     * @var NoteFactory
     */
    protected $noteFactory;

    /**
     * @var NoteCollectionFactory
     */
    protected $noteCollectionFactory;

    /**
     * @var Data\NoteSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param ResourceNote $resource
     * @param NoteFactory $noteFactory
     * @param NoteCollectionFactory $noteCollectionFactory
     * @param Data\NoteSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceNote $resource,
        NoteFactory $noteFactory,
        NoteCollectionFactory $noteCollectionFactory,
        Data\NoteSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->noteFactory = $noteFactory;
        $this->noteCollectionFactory = $noteCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save note data.
     *
     * @param NoteInterface $note
     * @return NoteInterface
     * @throws CouldNotSaveException
     */
    public function save(NoteInterface $note): NoteInterface
    {
        try {
            $this->resource->save($note);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the note: %1', $exception->getMessage()),
                $exception
            );
        }
        return $note;
    }

    /**
     * Load note data by given id.
     *
     * @param int $noteId
     * @return NoteInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $noteId): NoteInterface
    {
        $note = $this->noteFactory->create();
        $this->resource->load($note, $noteId);
        if (!$note->getNoteId()) {
            throw new NoSuchEntityException(__('The note with the "%1" ID doesn\'t exist.', $noteId));
        }
        return $note;
    }

    /**
     * Load note data collection by given search criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return NoteSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): NoteSearchResultsInterface
    {
        $collection = $this->noteCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete note.
     *
     * @param NoteInterface $note
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(NoteInterface $note): bool
    {
        try {
            $this->resource->delete($note);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the note: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete note by given id.
     *
     * @param int $noteId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $noteId): bool
    {
        return $this->delete($this->getById($noteId));
    }
}
