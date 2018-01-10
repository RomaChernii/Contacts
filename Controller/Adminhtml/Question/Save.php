<?php
namespace Smile\Contacts\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;
use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Store\Model\Store;
use Smile\Contacts\Api\QuestionRepositoryInterface;
use Smile\Contacts\Model\QuestionFactory;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Contacts::question_save';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'contact/email/recipient_email';

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = 'contact/email/sender_email_identity';

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = 'contact/email/email_template';

    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'contact/contact/enabled';

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Smile\Contacts\Api\QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @var \Smile\Contacts\Model\QuestionFactory
     */
    protected $questionFactory;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        QuestionRepositoryInterface $questionRepository,
        QuestionFactory $questionFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $postObject = new DataObject();
            $postObject->setData($data);

            $id = $this->getRequest()->getParam('question_id');

            try {
                if (!$id) {
                    $model = $this->questionFactory->create();
                    $data['question_id']= null;
                } else {
                    $model = $this->questionRepository->getById($id);
                }

                    // quick answer start
                    $this->inlineTranslation->suspend();

                    $storeScope = ScopeInterface::SCOPE_STORE;
                    $transport = $this->_transportBuilder
                        ->setTemplateIdentifier('contact_admin_email_answer_template')
                        ->setTemplateOptions(
                            [
                                'area' => FrontNameResolver::AREA_CODE,
                                'store' => Store::DEFAULT_STORE_ID,
                            ]
                        )
                        ->setTemplateVars(['data' => $postObject])
                        ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
                        ->addTo($model->getEmail())
                        ->getTransport();

                    $transport->sendMessage();

                    $this->inlineTranslation->resume();
                    // quick answer end
                    $model->setData($data);
                    $model->setStatus(2);
                    $this->questionRepository->save($model);
                    $this->messageManager->addSuccess(__('You answered the question.'));
                    $this->dataPersistor->clear('contacts_question');

                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getById()]);
                    }
                    return $resultRedirect->setPath('*/*/');} catch (NoSuchEntityException $e) {
                        $this->messageManager->addError($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Something went wrong while answer the question.'));
                }

            $this->dataPersistor->set('contacts_questions', $data);
            return $resultRedirect->setPath('*/*/edit', ['question_id' => $this->getRequest()->getParam('question_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
