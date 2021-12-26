<?php

namespace PauloVictorDev\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;
use PauloVictorDev\Testimonials\Helper\Config;

class Save extends \Magento\Framework\App\Action\Action
{
    /** @var TestimonialFormInterface */
    protected $testimonialModel;

    /** @var TestimonialFormRepositoryInterface */
    protected $testimonialRepository;

    /** @var Config */
    protected $configHelper;

    public function __construct(
        TestimonialFormInterface $testimonialInterface,
        TestimonialFormRepositoryInterface $testimonialFormRepository,
        Config $configHelper,
        Context $context
    ) {
        parent::__construct($context);
        $this->testimonialModel = $testimonialInterface;
        $this->testimonialRepository = $testimonialFormRepository;
        $this->configHelper = $configHelper;
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$post) {
            return $resultRedirect->setRefererUrl();
        }

        try {
            //validar dados
            if (!$this->validate($post)) {
                throw new \Exception(__('Please enter all required fields.'));
            }

            $this->prepareData($post);
            $this->testimonialRepository->save($this->testimonialModel);
            $this->messageManager->addSuccessMessage(__($this->configHelper->getSubmitMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
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

    protected function prepareData($postData)
    {
        $this->testimonialModel->setName(filter_var($postData['name'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setDesignation(filter_var($postData['designation'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setCompany(filter_var($postData['company'], FILTER_SANITIZE_STRING));
        $this->testimonialModel->setEmail(filter_var($postData['email'], FILTER_SANITIZE_SPECIAL_CHARS));
//        $this->testimonialModel->setImage();
        $this->testimonialModel->setMessage(filter_var($postData['message'], FILTER_SANITIZE_SPECIAL_CHARS));
    }
}
