<?php

namespace PauloVictorDev\Testimonials\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const PATH_TESTIMONIAL_ENABLE                  = 'testimonial/general/enable';
    const PATH_TESTIMONIAL_FORM_ENABLE_PICTURE     = 'testimonial/form/enable_picture';
    const PATH_TESTIMONIAL_FORM_ENABLE_DESIGNATION = 'testimonial/form/enable_designation';
    const PATH_TESTIMONIAL_FORM_ENABLE_COMPANY     = 'testimonial/form/enable_company';
    const PATH_TESTIMONIAL_FORM_ENABLE_EMAIL       = 'testimonial/form/enable_email';
    const PATH_TESTIMONIAL_FORM_SUBMIT_MESSAGE     = 'testimonial/form/submit_message';


    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function isEnabled(): bool
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_ENABLE);
    }

    public function isDesignationEnabled(): bool
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_FORM_ENABLE_DESIGNATION);
    }

    public function isCompanyEnabled(): bool
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_FORM_ENABLE_COMPANY);
    }

    public function isEmailEnabled(): bool
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_FORM_ENABLE_EMAIL);
    }

    public function isPictureEnabled(): bool
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_FORM_ENABLE_PICTURE);
    }

    public function getSubmitMessage(): string
    {
        return $this->getConfig(self::PATH_TESTIMONIAL_FORM_SUBMIT_MESSAGE);
    }

    protected function getConfig(string $key)
    {
        return $this->scopeConfig->getValue($key, ScopeInterface::SCOPE_STORE);
    }
}
