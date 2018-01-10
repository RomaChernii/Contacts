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
    protected $model;

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
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('question_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // init model and delete
                $model = $this->model;
                $model->deleteById($id);
                // display success message
                $this->messageManager->addSuccess(__('The question has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['question_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a question to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
