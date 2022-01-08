<?php

namespace PauloVictorDev\Testimonials\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;

interface TestimonialFormRepositoryInterface
{
    /**
     * Retrieve a record by Id.
     *
     * @param int $testimonialId
     * @return TestimonialFormInterface|null
     * @throws NoSuchEntityException if a record with id is not found.
     * @throws LocalizedException
     */
    public function getById(int $testimonialId): ?TestimonialFormInterface;

    /**
     * Create or Update Testimonial object
     * @param TestimonialFormInterface $testimonialForm
     * @return TestimonialFormInterface
     */
    public function save(TestimonialFormInterface $testimonialForm): ?TestimonialFormInterface;

    /**
     * Delete Testimonial record from the table
     *
     * @param TestimonialFormInterface $testimonialForm
     * @return bool|null
     * @throws NoSuchEntityException if a record with id is not found.
     * @throws LocalizedException
     */
    public function delete(TestimonialFormInterface $testimonialForm): ?bool;

    /**
     *  Delete Testimonial record from the table by Id.
     *
     * @param int $testimonialId
     * @return bool|null
     * @throws NoSuchEntityException if a record with id is not found.
     * @throws LocalizedException
     */
    public function deleteById(int $testimonialId): ?bool;

    /**
     * Retrieve the Testimonials
     *
     * @param int $limit
     * @return array
     * @throws NoSuchEntityException if record is not found.
     * @throws LocalizedException
     */
    public function getTestimonials(int $limit = 3): array;
}
