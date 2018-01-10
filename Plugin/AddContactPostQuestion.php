<?php
namespace Smile\Contacts\Plugin;

use Magento\Contact\Controller\Index\Post as Subject;
use Magento\Framework\Json\EncoderInterface as Encoder;
use Magento\Framework\App\Request\Http;
use Magento\Store\Model\StoreManagerInterface;
use Smile\Contacts\Model\QuestionFactory;

class AddContactPostQuestion
{
    protected $_request;
    protected $_questionFactory;
    protected $_storeManager;

    public function __construct(
        Http $_request,
        QuestionFactory $_questionFactory,
        StoreManagerInterface $_storeManager
    ) {
        $this->_request = $_request;
        $this->_questionFactory = $_questionFactory;
        $this->_storeManager = $_storeManager;
    }

    public function beforeExecute(Subject $subject)
    {
        $post = $this->_request->getPostValue();
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
                $question = $this->_questionFactory->create();
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
