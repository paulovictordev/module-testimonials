<?php

namespace PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PauloVictorDev\Testimonials\Model\TestimonialForm as TestimonialFormModel;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm as TestimonialFormResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(TestimonialFormModel::class, TestimonialFormResourceModel::class);
    }
}
