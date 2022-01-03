<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use PauloVictorDev\Testimonials\Model\Image;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;

class Delete extends Action
{
    /** @var TestimonialFormRepositoryInterface  */
    protected $testimonialFormRepository;

    /** @var Image  */
    protected $imageModel;

    public function __construct(
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        Image $imageModel,
        Context $context
    ) {
        parent::__construct($context);
        $this->testimonialFormRepository = $testimonialFormRepository;
        $this->imageModel = $imageModel;
    }

    public function execute()
    {
        $testimonialId = $this->getRequest()->getParam("entity_id");

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($testimonialId) {
            try {
                $testimonial = $this->testimonialFormRepository->getById($testimonialId);
                $this->testimonialFormRepository->delete($testimonial);

                if ($testimonial->getImage()) {
                    $this->imageModel->deleteFile($testimonial->getImage());
                }

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
