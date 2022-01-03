<?php

namespace PauloVictorDev\Testimonials\Block\Adminhtml\Index\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends Generic implements ButtonProviderInterface
{

    public function getButtonData()
    {
        $data = [];
        if ($this->getTestimonialId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    protected function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['testimonial_id' => $this->getTestimonialId()]);
    }
}
