<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm\CollectionFactory;

abstract class AbstractMassAction extends Action
{
    const ADMIN_RESOURCE = 'PauloVictorDev_Testimonials::testimonials';

    /** @var string  */
    protected $redirectUrl = '*/*/index';

    /** @var Filter  */
    protected $filter;

    /** @var CollectionFactory  */
    protected $collectionFactory;

    public function __construct(
        Filter $filter,
        CollectionFactory $collectionFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * Return component referer url
     *
     * @return string|null
     */
    protected function getComponentRefererUrl(): ?string
    {
        return $this->filter->getComponentRefererUrl()?: 'testimonials/*/index';
    }

    /**
     * Execute action to collection items
     *
     * @param AbstractCollection $collection
     * @return mixed
     */
    abstract protected function massAction(AbstractCollection $collection);
}
