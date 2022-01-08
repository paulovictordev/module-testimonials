<?php

namespace PauloVictorDev\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TestimonialForm extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('testimonials_data', 'entity_id');
    }
}
