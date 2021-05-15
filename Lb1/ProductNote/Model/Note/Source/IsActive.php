<?php

namespace Lb1\ProductNote\Model\Note\Source;

use Lb1\ProductNote\Api\Data\NoteInterface;
use Magento\Framework\Data\OptionSourceInterface;

class IsActive
    implements OptionSourceInterface
{
    /**
     * @var NoteInterface 
     */
    protected $note;

    /**
     * @param NoteInterface $note
     */
    public function __construct(NoteInterface $note)
    {
        $this->note = $note;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $availableOptions = $this->note->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
