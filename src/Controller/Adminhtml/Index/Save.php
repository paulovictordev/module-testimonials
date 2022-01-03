<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;

class Save extends Action
{
    /** @var TestimonialFormInterface */
    protected $testimonialModel;

    /** @var TestimonialFormRepositoryInterface */
    protected $testimonialRepository;

    /** @var DataPersistorInterface  */
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        TestimonialFormInterface $testimonialInterface,
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->testimonialModel = $testimonialInterface;
        $this->testimonialRepository = $testimonialFormRepository;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $testimonialId = $this->getTestimonialId();

            try {
                if (!is_null($testimonialId)) {
                    $this->testimonialModel = $this->testimonialRepository->getById($testimonialId);
                    $this->prepareData($data);
                    $this->testimonialRepository->save($this->testimonialModel);
                    $this->messageManager->addSuccessMessage('Successfully updated testimonial..');
                    $this->dataPersistor->clear('testimonialform_data');
                    return $resultRedirect;
                }

                $this->prepareData($data);
                $this->testimonialRepository->save($this->testimonialModel);
                $this->messageManager->addSuccessMessage('Successfully saved testimonial.');
                $this->dataPersistor->clear('testimonialform_data');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Testimonial.'));
            }
        }

        return $resultRedirect;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function prepareData(array $data)
    {
        $postData = $data['testimonial'];
        $this->testimonialModel->setName(filter_var($postData['name'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setDesignation(filter_var($postData['designation'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setCompany(filter_var($postData['company'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setEmail(filter_var($postData['email'], FILTER_SANITIZE_EMAIL));
        $this->testimonialModel->setImage($postData['image']);
        $this->testimonialModel->setMessage(filter_var($postData['message'], FILTER_SANITIZE_SPECIAL_CHARS));

        $this->dataPersistor->set('testimonialform_data', $this->testimonialModel);

        return $this;
    }

    /**
     * @return int|null
     */
    protected function getTestimonialId(): ?int
    {
        $testimonial = $this->getRequest()->getParam('testimonial');

        if (empty($testimonial['entity_id'])) {
            return null;
        }

        return $testimonial['entity_id'];
    }
}
