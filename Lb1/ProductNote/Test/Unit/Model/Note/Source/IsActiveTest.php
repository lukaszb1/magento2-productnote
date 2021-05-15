<?php
namespace Lb1\ProductNote\Test\Unit\Model\Note\Source;

use Lb1\ProductNote\Model\Note;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IsActiveTest extends TestCase
{
    /**
     * @var Note|MockObject
     */
    protected $noteMock;

    /**
     * @var ObjectManager
     */
    protected $objectManagerHelper;

    /**
     * @var Note\Source\isActive
     */
    protected $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->objectManagerHelper = new ObjectManager($this);
        $this->noteMock = $this->getMockBuilder(Note::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAvailableStatuses'])
            ->getMock();
        $this->object = $this->objectManagerHelper->getObject($this->getSourceClassName(), [
            'note' => $this->noteMock,
        ]);
    }

    /**
     * @return string
     */
    protected function getSourceClassName()
    {
        return Note\Source\IsActive::class;
    }

    /**
     * @param array $availableStatuses
     * @param array $expected
     * @return void
     * @dataProvider getAvailableStatusesDataProvider
     */
    public function testToOptionArray(array $availableStatuses, array $expected)
    {
        $this->noteMock->expects($this->once())
            ->method('getAvailableStatuses')
            ->willReturn($availableStatuses);

        $this->assertSame($expected, $this->object->toOptionArray());
    }

    /**
     * @return array
     */
    public function getAvailableStatusesDataProvider()
    {
        return [
            [
                [],
                [],
            ],
            [
                ['testStatus' => 'testValue'],
                [['label' => 'testValue', 'value' => 'testStatus']],
            ],
        ];
    }
}
