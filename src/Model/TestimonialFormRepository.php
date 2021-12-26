<?php

namespace PauloVictorDev\Testimonials\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PauloVictorDev\Testimonials\Model\TestimonialFormFactory;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm as TestimonialFormResourceModel;

class TestimonialFormRepository implements TestimonialFormRepositoryInterface
{
    /** @var TestimonialForm */
    protected $testimonialFormFactory;

    /** @var TestimonialFormResourceModel */
    protected $testimonialFormResourceModel;

    public function __construct(
        TestimonialFormFactory $testimonialFormFactory,
        TestimonialFormResourceModel $testimonialFormResourceModel
    ) {
        $this->testimonialFormFactory = $testimonialFormFactory;
        $this->testimonialFormResourceModel = $testimonialFormResourceModel;
    }

    public function getById(int $testimonialId): ?TestimonialFormInterface
    {
        $testimonialFormObj = $this->testimonialFormFactory->create();
        $this->testimonialFormResourceModel->load($testimonialFormObj, $testimonialId);

        if (!$testimonialFormObj->getTestimonialId()) {
            throw new NoSuchEntityException(__('Testimonials with Id "%1" not exist.', $testimonialId));
        }

        return $testimonialFormObj;
    }

    public function save(TestimonialFormInterface $testimonialForm): ?TestimonialFormInterface
    {
        try {
            $this->testimonialFormResourceModel->save($testimonialForm);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $testimonialForm;
    }

    public function delete(TestimonialFormInterface $testimonialForm): ?bool
    {
        try {
            $this->testimonialFormResourceModel->delete($testimonialForm);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    public function deleteById(int $testimonialId): ?bool
    {
        return $this->delete($this->getById($testimonialId));
    }
}
