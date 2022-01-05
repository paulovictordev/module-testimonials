<?php

namespace PauloVictorDev\Testimonials\Block\Widget;

use Magento\Framework\UrlInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use PauloVictorDev\Testimonials\Helper\Config;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use PauloVictorDev\Testimonials\Model\TestimonialFormRepository;

class Show extends Template implements BlockInterface
{
    protected $_template = "widget/show.phtml";

    /** @var Config  */
    protected $configHelper;

    /** @var TestimonialFormRepository  */
    protected $testimonialFormRepository;

    /** @var StoreManagerInterface  */
    protected $storeManager;

    public function __construct(
        Context $context,
        Config $configHelper,
        TestimonialFormRepository $testimonialFormRepository,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configHelper = $configHelper;
        $this->testimonialFormRepository = $testimonialFormRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->configHelper->isEnabled();
    }

    /**
     * @return array
     */
    public function getTestimonials(): array
    {
        return $this->testimonialFormRepository->getTestimonials($this->getData('items_number'));
    }

    /**
     * @param string $path
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTestimonialImageUrl(string $path): string
    {
        $mediaUrl =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . $path;
    }

    /**
     * @return string
     */
    public function getTestimonialImageEmpty(): string
    {
        return $this->getViewFileUrl('PauloVictorDev_Testimonials::images/avatar.jpg');
    }

    /**
     * @return bool
     */
    public function isDesignationEnabled(): bool
    {
        return $this->configHelper->isDesignationEnabled();
    }

    /**
     * @return bool
     */
    public function isCompanyEnabled(): bool
    {
        return $this->configHelper->isCompanyEnabled();
    }

    /**
     * @return bool
     */
    public function isEmailEnabled(): bool
    {
        return $this->configHelper->isEmailEnabled();
    }

    /**
     * @return bool
     */
    public function isPictureEnabled(): bool
    {
        return $this->configHelper->isPictureEnabled();
    }
}
