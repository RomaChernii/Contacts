<?php
namespace Smile\Contacts\Plugin;

use Magento\Contact\Controller\Index\Post as Subject;
use Magento\Framework\App\Request\Http;
use Smile\Contacts\Model\QuestionFactory;

class AddContactPostQuestion
{
    private $request;

    private $questionFactory;

    public function __construct(
        Http $request,
        QuestionFactory $questionFactory
    ) {
        $this->request = $request;
        $this->questionFactory = $questionFactory;
    }

    public function beforeExecute(Subject $subject)
    {
        $post = $this->request->getPostValue();
        if (!$post) {
            return;
        }
        try {
            $error = false;
            if (!\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['comment']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                $error = true;
            }
            if (!$error) {
                $question = $this->questionFactory->create();
                $question->setData($post)
                    ->setPhone(trim($post['telephone']))
                    ->setContent(trim($post['comment']))
                    ->save();
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
