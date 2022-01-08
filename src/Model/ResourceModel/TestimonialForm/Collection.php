<?php

namespace PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PauloVictorDev\Testimonials\Model\TestimonialForm as TestimonialFormModel;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm as TestimonialFormResourceModel;

class Collection extends AbstractCollection
{
    /** @var string  */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(TestimonialFormModel::class, TestimonialFormResourceModel::class);
    }
}
