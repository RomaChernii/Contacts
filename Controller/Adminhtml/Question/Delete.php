<?php
namespace Smile\Contacts\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Smile\Contacts\Api\QuestionRepositoryInterface;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Contacts::question_delete';

    /**
     * @var \Smile\Contacts\Api\QuestionRepositoryInterface
     */
    private $model;

    /**
     * @param Action\Context $context
     * @param Smile\Contacts\Api\QuestionRepositoryInterface; $model
     */
    public function __construct(
        Action\Context $context,
        QuestionRepositoryInterface $model
    ) {
        parent::__construct($context);
        $this->model = $model;
    }
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('question_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->model;
                $model->deleteById($id);
                $this->messageManager->addSuccess(__('The question has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['question_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a question to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
