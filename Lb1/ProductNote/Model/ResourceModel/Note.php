<?php namespace Lb1\ProductNote\Model\ResourceModel;

class Note
    extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheriDoc
     */
    protected function _construct()
    {
        $this->_init('lb1_productnote_note', 'note_id');
    }
}
