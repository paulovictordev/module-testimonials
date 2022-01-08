<?php

namespace PauloVictorDev\Testimonials\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use PauloVictorDev\Testimonials\Model\TestimonialFormFactory;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;
use PauloVictorDev\Testimonials\Api\TestimonialFormRepositoryInterface;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm\CollectionFactory;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm as TestimonialFormResourceModel;

class TestimonialFormRepository implements TestimonialFormRepositoryInterface
{
    /** @var TestimonialForm */
    protected $testimonialFormFactory;

    /** @var TestimonialFormResourceModel */
    protected $testimonialFormResourceModel;

    /** @var CollectionFactory  */
    protected $collectionFactory;

    public function __construct(
        TestimonialFormFactory $testimonialFormFactory,
        TestimonialFormResourceModel $testimonialFormResourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->testimonialFormFactory = $testimonialFormFactory;
        $this->testimonialFormResourceModel = $testimonialFormResourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $testimonialId
     * @return TestimonialFormInterface|null
     * @throws NoSuchEntityException
     */
    public function getById(int $testimonialId): ?TestimonialFormInterface
    {
        $testimonialFormObj = $this->testimonialFormFactory->create();
        $this->testimonialFormResourceModel->load($testimonialFormObj, $testimonialId);

        if (!$testimonialFormObj->getTestimonialId()) {
            throw new NoSuchEntityException(__('Testimonials with Id "%1" not exist.', $testimonialId));
        }

        return $testimonialFormObj;
    }

    /**
     * @param TestimonialFormInterface $testimonialForm
     * @return TestimonialFormInterface|null
     * @throws CouldNotSaveException
     */
    public function save(TestimonialFormInterface $testimonialForm): ?TestimonialFormInterface
    {
        try {
            $this->testimonialFormResourceModel->save($testimonialForm);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $testimonialForm;
    }

    /**
     * @param TestimonialFormInterface $testimonialForm
     * @return bool|null
     * @throws CouldNotDeleteException
     */
    public function delete(TestimonialFormInterface $testimonialForm): ?bool
    {
        try {
            $this->testimonialFormResourceModel->delete($testimonialForm);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * @param int $testimonialId
     * @return bool|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $testimonialId): ?bool
    {
        return $this->delete($this->getById($testimonialId));
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getTestimonials(int $limit = 3): array
    {
        $testimonials = $this->collectionFactory->create()
            ->addFieldToFilter('status', TestimonialForm::STATUS_APPROVED)
            ->addFieldToFilter('visible', true)
            ->setPageSize($limit);

        return $testimonials->getItems();
    }
}
