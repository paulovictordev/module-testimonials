<?php

namespace PauloVictorDev\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Context;
use PauloVictorDev\Testimonials\Model\Image;
use PauloVictorDev\Testimonials\Helper\Config;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;

class Save extends \Magento\Framework\App\Action\Action
{
    /** @var TestimonialFormInterface */
    protected $testimonialModel;

    /** @var TestimonialFormRepositoryInterface */
    protected $testimonialRepository;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /** @var Config */
    protected $configHelper;

    /** @var Image  */
    protected $imageModel;

    public function __construct(
        TestimonialFormInterface $testimonialInterface,
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        DataPersistorInterface $dataPersistor,
        Config $configHelper,
        Image $imageModel,
        Context $context
    ) {
        parent::__construct($context);
        $this->testimonialModel = $testimonialInterface;
        $this->testimonialRepository = $testimonialFormRepository;
        $this->dataPersistor = $dataPersistor;
        $this->configHelper = $configHelper;
        $this->imageModel = $imageModel;
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$post) {
            return $resultRedirect->setRefererUrl();
        }

        try {
            if (!$this->validate($post)) {
                throw new \Exception(__('Please enter all required fields.'));
            }

            $this->prepareData($post);
            $this->testimonialRepository->save($this->testimonialModel);
            $this->messageManager->addSuccessMessage(__($this->configHelper->getSubmitMessage()));
            $this->dataPersistor->clear('testimonialform_data');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Testimonial.'));
            $this->dataPersistor->set('testimonialform_data', $this->testimonialModel);
        }

        return $resultRedirect->setRefererUrl();
    }

    protected function validate($data)
    {
        $valid = true;

        if (array_key_exists('name', $data) && empty(trim($data['name']))) {
            $valid = false;
        }

        if ($this->configHelper->isEmailEnabled()) {
            if (array_key_exists('email', $data) && empty(trim($data['email']))) {
                $valid = false;
            }
        }

        if (array_key_exists('message', $data) && empty(trim($data['message']))) {
            $valid = false;
        }

        return $valid;
    }

    protected function prepareData(array $postData): void
    {
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

        $imagePath = $this->imageModel->uploadFile('picture');
        $this->testimonialModel->setImage($imagePath);

        $this->testimonialModel->setMessage(filter_var($postData['message'], FILTER_SANITIZE_SPECIAL_CHARS));
    }
}
