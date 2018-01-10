<?php
namespace Smile\Contacts\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Contacts Question Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Smile\Contacts\Model\Question', 'Smile\Contacts\Model\ResourceModel\Question');
    }
}
