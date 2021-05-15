<?php

namespace Lb1\ProductNote\Controller\Product;

use Lb1\ProductNote\Api\NoteRepositoryInterface;
use Lb1\ProductNote\Model\NoteFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

class Post
    implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var NoteFactory
     */
    protected $noteFactory;

    /**
     * @var NoteRepositoryInterface
     */
    protected $noteRepository;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param Validator $formKeyValidator
     * @param ProductRepositoryInterface $productRepository
     * @param NoteRepositoryInterface $noteRepository
     * @param NoteFactory $noteFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        ProductRepositoryInterface $productRepository,
        NoteRepositoryInterface $noteRepository,
        NoteFactory $noteFactory
    ) {
        $this->request = $context->getRequest();
        $this->redirect = $context->getRedirect();
        $this->resultFactory = $context->getResultFactory();
        $this->messageManager = $context->getMessageManager();
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->noteFactory = $noteFactory;
        $this->noteRepository = $noteRepository;
    }

    /**
     * @return Redirect
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->request)) {
            $resultRedirect->setUrl(
                $this->redirect->getRefererUrl()
            );
            return $resultRedirect;
        }

        $data = $this->request->getPostValue();
        if (!empty($data)) {
            try {
                $note = $this->noteFactory->create();
                $note->setData($data);
                $note->setProductId((int)$this->getProduct()->getId());
                $note->setCustomerId((int)$this->customerSession->getId());
                $note->setStoreId((int)$this->storeManager->getStore()->getId());
                $note->setIsActive(true);

                $this->noteRepository->save($note);
                $this->messageManager->addSuccessMessage(__('You submitted your note.'));
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        
        $resultRedirect->setUrl(
            $this->redirect->getRedirectUrl()
        );
        return $resultRedirect;
    }

    /**
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    private function getProduct(): ProductInterface
    {
        $product = $this->productRepository->getById(
            (int)$this->request->getParam('product_id')
        );
        if (!in_array($this->storeManager->getStore()->getWebsiteId(), $product->getWebsiteIds())) {
            throw new NoSuchEntityException();
        }
        if (!$product->isVisibleInCatalog() || !$product->isVisibleInSiteVisibility()) {
            throw new NoSuchEntityException();
        }
        return $product;
    }
}
