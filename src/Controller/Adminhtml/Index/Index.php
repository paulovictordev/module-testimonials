<?php

namespace PauloVictorDev\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        PageFactory $resultPageFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Testimonials'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PauloVictorDev_Testimonials::testimonials');
    }
}
