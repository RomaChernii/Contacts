<?php
namespace Smile\Contacts\Api\Data;

interface QuestionInterface
{
    const QUESTION_ID   = 'question_id';
    const NAME          = 'name';
    const EMAIL         = 'email';
    const PHONE         = 'phone';
    const CONTENT       = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const STATUS        = 'status';
    const ANSWER        = 'answer';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get phone
     *
     * @return int|null
     */
    public function getPhone();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Get status
     *
     * @return bool|null
     */
    public function getStatus();

    /**
     * Get answer
     *
     * @return string|null
     */
    public function getAnswer();

    /**
     * Set ID
     *
     * @param int $id
     * @return QuestionInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return QuestionInterface
     */
    public function setName($name);

    /**
     * Set email
     *
     * @param string $email
     * @return QuestionInterface
     */
    public function setEmail($email);

    /**
     * Set phone
     *
     * @param int $phone
     * @return QuestionInterface
     */
    public function setPhone($phone);

    /**
     * Set content
     *
     * @param string $content
     * @return QuestionInterface
     */
    public function setContent($content);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return QuestionInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return QuestionInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set status
     *
     * @param bool|int $status
     * @return QuestionInterface
     */
    public function setStatus($status);

    /**
     * Set answer
     *
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer($answer);
}
