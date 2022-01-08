<?php

namespace PauloVictorDev\Testimonials\Block\Widget;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use PauloVictorDev\Testimonials\Helper\Config;
use Magento\Framework\View\Element\Template\Context;

class Form extends Template implements BlockInterface
{
    protected $_template = "widget/form.phtml";

    protected $configHelper;

    public function __construct(
        Config $configHelper,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configHelper = $configHelper;
    }

    public function getFormAction()
    {
        return $this->getUrl('testimonials/index/save');
    }

    public function isEnabled(): bool
    {
        return $this->configHelper->isEnabled();
    }

    public function isDesignationEnabled(): bool
    {
        return $this->configHelper->isDesignationEnabled();
    }

    public function isCompanyEnabled(): bool
    {
        return $this->configHelper->isCompanyEnabled();
    }

    public function isEmailEnabled(): bool
    {
        return $this->configHelper->isEmailEnabled();
    }

    public function isPictureEnabled(): bool
    {
        return $this->configHelper->isPictureEnabled();
    }
}
