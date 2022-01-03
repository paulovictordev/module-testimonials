<?php

namespace PauloVictorDev\Testimonials\Block\Adminhtml\Index\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends Generic implements ButtonProviderInterface
{

    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'sort_order' => 90,
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ]
        ];
    }
}
