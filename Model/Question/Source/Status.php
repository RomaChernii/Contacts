<?php
namespace Smile\Contacts\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Smile\Contacts\Model\Question;

/**
 * Class Question Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \Smile\Contacts\Model\Question
     */
    private $question;

    /**
     * Constructor
     *
     * @param \Smile\Contacts\Model\Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->question->getAvailableStatuses();
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
