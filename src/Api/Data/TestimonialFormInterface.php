<?php

namespace PauloVictorDev\Testimonials\Api\Data;

interface TestimonialFormInterface
{
    const TESTIMONIAL_ID = 'entity_id';
    const STATUS = 'status';
    const VISIBLE = 'visible';
    const NAME = 'name';
    const EMAIL = 'email';
    const DESIGNATION = 'designation';
    const COMPANY = 'company';
    const PICTURE = 'image';
    const MESSAGE = 'message';

    /**
     * @return int
     */
    public function getTestimonialId(): int;

    /**
     * @param int $testimonialId
     * @return $this
     */
    public function setTestimonialId(int $testimonialId);

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @return bool
     */
    public function geVisible(): bool;

    /**
     * @param bool $visible
     * @return $this
     */
    public function setVisible(bool $visible);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getDesignation(): string;

    /**
     * @param string $designation
     * @return $this
     */
    public function setDesignation(string $designation);

    /**
     * @return string
     */
    public function getCompany(): string;

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany(string $company);

    /**
     * @return string
     */
    public function getImage(): string;

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image);

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message);
}
