<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;
use PauloVictorDev\Testimonials\Controller\Adminhtml\AbstractMassAction;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm\CollectionFactory;

class MassDisable extends AbstractMassAction implements HttpPostActionInterface
{
    /** @var TestimonialFormRepositoryInterface  */
    protected $testimonialFormRepository;

    public function __construct(
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Context $context
    ) {
        parent::__construct($filter, $collectionFactory, $context);
        $this->testimonialFormRepository = $testimonialFormRepository;
    }

    protected function massAction(AbstractCollection $collection)
    {
        $testimonialsDesabled = 0;
        foreach ($collection->getAllIds() as $id) {
            $testimonial = $this->testimonialFormRepository->getById($id);
            $testimonial->setVisible(false);
            $this->testimonialFormRepository->save($testimonial);
            $testimonialsDesabled++;
        }

        if ($testimonialsDesabled) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were desabled.', $testimonialsDesabled));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
