<?php

namespace PauloVictorDev\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use PauloVictorDev\Testimonials\Api\Data\TestimonialFormInterface;

class TestimonialForm extends AbstractModel implements TestimonialFormInterface, IdentityInterface
{
    const STATUS_DISAPPROVED = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;

    const CACHE_TAG = 'testimonial';

    protected $_cacheTag = 'testimonial';

    protected function _construct()
    {
        $this->_init(\PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm::class);
    }

    /**
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getTestimonialId()];
    }

    /**
     * @return int
     */
    public function getTestimonialId(): int
    {
        return $this->getData(self::TESTIMONIAL_ID);
    }

    /**
     * @param int $testimonialId
     * @return TestimonialForm
     */
    public function setTestimonialId(int $testimonialId)
    {
        return $this->setData(self::TESTIMONIAL_ID, $testimonialId);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param int $status
     * @return TestimonialForm
     */
    public function setStatus(int $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return bool
     */
    public function geVisible(): bool
    {
        return $this->getData(self::VISIBLE);
    }

    /**
     * @param bool $visible
     * @return TestimonialForm
     */
    public function setVisible(bool $visible)
    {
        return $this->setData(self::VISIBLE, $visible);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return TestimonialForm
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param string $email
     * @return TestimonialForm
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string|null
     */
    public function getDesignation(): ?string
    {
        return $this->getData(self::DESIGNATION);
    }

    /**
     * @param string $designation
     * @return TestimonialForm
     */
    public function setDesignation(string $designation)
    {
        return $this->setData(self::DESIGNATION, $designation);
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->getData(self::COMPANY);
    }

    /**
     * @param string $company
     * @return TestimonialForm
     */
    public function setCompany(string $company)
    {
        return $this->setData(self::COMPANY, $company);
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::PICTURE);
    }

    /**
     * @param string $image
     * @return TestimonialForm
     */
    public function setImage(string $image)
    {
        return $this->setData(self::PICTURE, $image);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @param string $message
     * @return TestimonialForm
     */
    public function setMessage(string $message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Returns the Status of Testimonials
     *
     * @return array
     */
    public function getAvailableStatus(): array
    {
        return [
            self::STATUS_DISAPPROVED => __('Disapproved'),
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_APPROVED => __('Approved')
        ];
    }
}
