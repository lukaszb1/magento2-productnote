<?php declare(strict_types=1);

namespace Lb1\ProductNote\Model;

use Lb1\ProductNote\Api\Data\NoteInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Validator\DataObjectFactory;
use Magento\Framework\Validator\NotEmpty;

class Note
    extends AbstractModel
    implements IdentityInterface, NoteInterface
{
    /**
     * Note block cache tag
     */
    const CACHE_TAG = 'lb1_productnote_note';

    /**#@+
     * Note's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'lb1_productnote_note';

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * Factory for validator object
     *
     * @var DataObjectFactory
     */
    protected $validator;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param DateTime $dateTime
     * @param DataObjectFactory $validator
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DateTime $dateTime,
        DataObjectFactory $validator,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->dateTime = $dateTime;
        $this->validator = $validator;
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(\Lb1\ProductNote\Model\ResourceModel\Note::class);
    }

    /**
     * @inheritDoc
     */
    protected function _getValidationRulesBeforeSave()
    {
        $contentNotEmpty = new NotEmpty();
        $contentNotEmpty->setMessage(
            __('Please enter a note content.'),
            NotEmpty::IS_EMPTY
        );
        return $this->validator->create()->addRule($contentNotEmpty, 'content');
    }

    /**
     * @return $this
     */
    public function beforeSave(): self
    {
        parent::beforeSave();
        if ($this->isObjectNew() && !$this->getCreatedAt()) {
            $this->setCreatedAt($this->dateTime->gmtDate());
        }
        $this->setUpdatedAt($this->dateTime->gmtDate());
        return $this;
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Prepare note's statuses
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * @return int|null
     */
    public function getNoteId(): ?int
    {
        return (int)$this->getData(self::NOTE_ID) ?: null;
    }

    /**
     * @param int|null $id
     * @return NoteInterface
     */
    public function setNoteId(?int $id): NoteInterface
    {
        $this->setData(self::NOTE_ID, $id);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @param string $content
     * @return NoteInterface
     */
    public function setContent(string $content): NoteInterface
    {
        $this->setData(self::CONTENT, $content);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return (int)$this->getData(self::NOTE_ID) ?: null;
    }

    /**
     * @param int|null $id
     * @return NoteInterface
     */
    public function setProductId(?int $id): NoteInterface
    {
        $this->setData(self::PRODUCT_ID, $id);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param int|null $id
     * @return NoteInterface
     */
    public function setCustomerId(?int $id): NoteInterface
    {
        $this->setData(self::CUSTOMER_ID, $id);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @param int|null $id
     * @return NoteInterface
     */
    public function setStoreId(?int $id): NoteInterface
    {
        $this->setData(self::STORE_ID, $id);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return NoteInterface
     */
    public function setCreatedAt(string $createdAt): NoteInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string|null $updatedAt
     * @return NoteInterface
     */
    public function setUpdatedAt(?string $updatedAt): NoteInterface
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * @param bool $isActive
     * @return NoteInterface
     */
    public function setIsActive(bool $isActive): NoteInterface
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }
}
