<?php
namespace Smile\Contacts\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\Contacts\Api\Data\QuestionInterface;

interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param \Smile\Contacts\Api\Data\QuestionInterface $question
     * @return \Smile\Contacts\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(QuestionInterface $question);

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return \Smile\Contacts\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId);

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Smile\Contacts\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param \Smile\Contacts\Api\Data\QuestionInterface $question
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(QuestionInterface $question);

    /**
     * Delete question by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($questionId);
}
