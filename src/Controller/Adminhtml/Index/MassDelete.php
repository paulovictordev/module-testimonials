<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use PauloVictorDev\Testimonials\Model\Image;
use Magento\Framework\Controller\ResultFactory;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;
use PauloVictorDev\Testimonials\Controller\Adminhtml\AbstractMassAction;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm\CollectionFactory;

class MassDelete extends AbstractMassAction implements HttpPostActionInterface
{
    /** @var TestimonialFormRepositoryInterface  */
    protected $testimonialFormRepository;

    /** @var Image  */
    protected $imageModel;

    public function __construct(
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Image $imageModel,
        Context $context
    ) {
        parent::__construct($filter, $collectionFactory, $context);
        $this->testimonialFormRepository = $testimonialFormRepository;
        $this->imageModel = $imageModel;
    }

    protected function massAction(AbstractCollection $collection)
    {
        $testimonialsDeleted = 0;
        foreach ($collection->getAllIds() as $id) {
            $testimonial = $this->testimonialFormRepository->getById($id);
            $this->testimonialFormRepository->delete($testimonial);

            if ($testimonial->getImage()) {
                $this->imageModel->deleteFile($testimonial->getImage());
            }

            $testimonialsDeleted++;
        }

        if ($testimonialsDeleted) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were deleted.', $testimonialsDeleted));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
