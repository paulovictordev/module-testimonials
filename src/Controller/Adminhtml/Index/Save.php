<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use PauloVictorDev\Testimonials\Model\Image;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;
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

    protected $imageModel;

    public function __construct(
        Action\Context $context,
        TestimonialFormInterface $testimonialInterface,
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        DataPersistorInterface $dataPersistor,
        Image $imageModel
    ) {
        $this->testimonialModel = $testimonialInterface;
        $this->testimonialRepository = $testimonialFormRepository;
        $this->dataPersistor = $dataPersistor;
        $this->imageModel = $imageModel;
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

        if (!empty($postData['designation'])) {
            $this->testimonialModel->setDesignation(filter_var($postData['designation'], FILTER_SANITIZE_STRING));
        }

        if (!empty($postData['company'])) {
            $this->testimonialModel->setCompany(filter_var($postData['company'], FILTER_SANITIZE_STRING));
        }

        if (!empty($postData['email'])) {
            $this->testimonialModel->setEmail(filter_var($postData['email'], FILTER_SANITIZE_EMAIL));
        }

        $testimonialImage = $this->testimonialModel->getImage() ?? '';
        $imageName = $postData['image'][0]['name'] ?? '';

        if (!empty($imageName)) {
            $imagePath = $this->imageModel->saveFile($imageName);
            $this->testimonialModel->setImage($imagePath);

            if (!!$testimonialImage && $testimonialImage != $imagePath) {
                $this->imageModel->deleteFile($testimonialImage);
            }
        } elseif ($testimonialImage) {
            $this->imageModel->deleteFile($this->testimonialModel->getImage());
            $this->testimonialModel->setImage('');
        }

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
