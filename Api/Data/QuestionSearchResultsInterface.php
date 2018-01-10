<?php
namespace Smile\Contacts\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \Smile\Contacts\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param \Smile\Contacts\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
