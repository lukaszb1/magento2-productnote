<?php

namespace Lb1\ProductNote\Api\Data;

/**
 * @api
 */
interface NoteInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const NOTE_ID = 'note_id';
    const CONTENT = 'content';
    const PRODUCT_ID = 'product_id';
    const CUSTOMER_ID = 'customer_id';
    const STORE_ID = 'store_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_ACTIVE = 'is_active';

    const ATTRIBUTES = [
        self::NOTE_ID,
        self::CONTENT,
        self::PRODUCT_ID,
        self::CUSTOMER_ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::IS_ACTIVE,
    ];
    /**#@-*/
    
    public function getAvailableStatuses(): array;

    /**
     * Get note id
     *
     * @return int|null
     */
    public function getNoteId(): ?int;

    /**
     * Set note id
     *
     * @param int|null $id
     * @return $this
     */
    public function setNoteId(?int $id): self;

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Set content
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self;

    /**
     * Get product id
     *
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set product id
     *
     * @param int|null $id
     * @return $this
     */
    public function setProductId(?int $id): self;

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer id
     *
     * @param int|null $id
     * @return $this
     */
    public function setCustomerId(?int $id): self;

    /**
     * Get store id
     *
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * Set store id
     *
     * @param int|null $id
     * @return $this
     */
    public function setStoreId(?int $id): self;

    /**
     * Product created date
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set note created date
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * Note updated date
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set note updated date
     *
     * @param string|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?string $updatedAt): self;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): self;
}
