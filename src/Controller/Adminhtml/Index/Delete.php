<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;

class Delete extends Action
{
    /** @var TestimonialFormRepositoryInterface  */
    protected $testimonialFormRepository;

    public function __construct(
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        Context $context
    ) {
        parent::__construct($context);
        $this->testimonialFormRepository = $testimonialFormRepository;
    }

    public function execute()
    {
        $testimonialId = $this->getRequest()->getParam("id");

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($testimonialId) {
            try {
                $this->testimonialFormRepository->deleteById($testimonialId);
                $this->messageManager->addSuccessMessage('Testimonial was deleted.');
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['testimonial_id' => $testimonialId]);
            }
        }

        $this->messageManager->addErrorMessage(__('It was not possible to delete testimonial.'));
        return $resultRedirect->setPath('*/*/');
    }
}
