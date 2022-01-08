<?php

namespace PauloVictorDev\Testimonials\Block\Adminhtml\Index\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\PageRepositoryInterface;

class Generic
{
    /** @var Context  */
    protected $context;

    /** @var PageRepositoryInterface  */
    protected $pageRepository;

    public function __construct(
        Context $context,
        PageRepositoryInterface $pageRepository
    ) {
        $this->context = $context;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * @return int|null
     */
    public function getTestimonialId(): ?int
    {
        return $this->context->getRequest()->getParam('testimonial_id');
    }
}
