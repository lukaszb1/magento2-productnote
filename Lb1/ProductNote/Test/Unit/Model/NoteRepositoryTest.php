<?php

namespace Lb1\ProductNote\Test\Unit\Model;

use Lb1\ProductNote\Model\NoteRepository;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Test for Lb1\ProductNoteModel\NoteRepository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class NoteRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var NoteRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Lb1\ProductNote\Model\ResourceModel\Note
     */
    protected $noteResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Lb1\ProductNote\Model\Note
     */
    protected $note;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Lb1\ProductNote\Api\Data\NoteInterface
     */
    protected $noteData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Lb1\ProductNote\Api\Data\NoteSearchResultsInterface
     */
    protected $noteSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Lb1\ProductNote\Model\ResourceModel\Note\Collection
     */
    protected $collection;

    /**
     * @var CollectionProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionProcessor;

    /**
     * Initialize repository
     */
    protected function setUp()
    {
        $this->noteResource = $this->getMockBuilder(\Lb1\ProductNote\Model\ResourceModel\Note::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder(\Magento\Framework\Reflection\DataObjectProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();
        $noteFactory = $this->getMockBuilder(\Lb1\ProductNote\Model\NoteFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $noteDataFactory = $this->getMockBuilder(\Lb1\ProductNote\Api\Data\NoteInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $noteSearchResultFactory = $this->getMockBuilder(\Lb1\ProductNote\Api\Data\NoteSearchResultsInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $collectionFactory = $this->getMockBuilder(\Lb1\ProductNote\Model\ResourceModel\Note\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->note = $this->getMockBuilder(\Lb1\ProductNote\Model\Note::class)->disableOriginalConstructor()->getMock();
        $this->noteData = $this->getMockBuilder(\Lb1\ProductNote\Api\Data\NoteInterface::class)
            ->getMock();
        $this->noteSearchResult = $this->getMockBuilder(\Lb1\ProductNote\Api\Data\NoteSearchResultsInterface::class)
            ->getMock();
        $this->collection = $this->getMockBuilder(\Lb1\ProductNote\Model\ResourceModel\Note\Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $noteFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->note);
        $noteDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->noteData);
        $noteSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->noteSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);
        $this->collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
            ->getMockForAbstractClass();

        $this->repository = new NoteRepository(
            $this->noteResource,
            $noteFactory,
            $collectionFactory,
            $noteSearchResultFactory,
            $this->collectionProcessor
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->noteResource->expects($this->once())
            ->method('save')
            ->with($this->note)
            ->willReturnSelf();
        $this->assertEquals($this->note, $this->repository->save($this->note));
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $noteId = '123';

        $this->note->expects($this->once())
            ->method('getNoteId')
            ->willReturn(true);
        $this->noteResource->expects($this->once())
            ->method('load')
            ->with($this->note, $noteId)
            ->willReturn($this->note);
        $this->noteResource->expects($this->once())
            ->method('delete')
            ->with($this->note)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($noteId));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->noteResource->expects($this->once())
            ->method('save')
            ->with($this->note)
            ->willThrowException(new \Exception());
        $this->repository->save($this->note);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function testDeleteException()
    {
        $this->noteResource->expects($this->once())
            ->method('delete')
            ->with($this->note)
            ->willThrowException(new \Exception());
        $this->repository->delete($this->note);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testGetByIdException()
    {
        $noteId = '123';

        $this->note->expects($this->once())
            ->method('getNoteId')
            ->willReturn(false);
        $this->noteResource->expects($this->once())
            ->method('load')
            ->with($this->note, $noteId)
            ->willReturn($this->note);
        $this->repository->getById($noteId);
    }

    /**
     * @test
     */
    public function testGetList()
    {
        $total = 10;

        /** @var \Magento\Framework\Api\SearchCriteriaInterface $criteria */
        $criteria = $this->getMockBuilder(\Magento\Framework\Api\SearchCriteriaInterface::class)->getMock();

        $this->collection->addItem($this->note);
        $this->collection->expects($this->once())
            ->method('getSize')
            ->willReturn($total);

        $this->collectionProcessor->expects($this->once())
            ->method('process')
            ->with($criteria, $this->collection)
            ->willReturnSelf();

        $this->noteSearchResult->expects($this->once())
            ->method('setSearchCriteria')
            ->with($criteria)
            ->willReturnSelf();
        $this->noteSearchResult->expects($this->once())
            ->method('setTotalCount')
            ->with($total)
            ->willReturnSelf();
        $this->noteSearchResult->expects($this->once())
            ->method('setItems')
            ->with([$this->note])
            ->willReturnSelf();
        $this->assertEquals($this->noteSearchResult, $this->repository->getList($criteria));
    }
}
