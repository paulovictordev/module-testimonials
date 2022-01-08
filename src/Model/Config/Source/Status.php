<?php

namespace PauloVictorDev\Testimonials\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use PauloVictorDev\Testimonials\Model\TestimonialForm;

class Status implements OptionSourceInterface
{
    /** @var TestimonialForm  */
    protected $testimonialForm;

    public function __construct(
        TestimonialForm $testimonialForm
    ) {
        $this->testimonialForm = $testimonialForm;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->testimonialForm->getAvailableStatus();

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
