<?php

class FormTest extends \PHPUnit\Framework\TestCase
{
    protected $objectHelper;

    public function setUp()
    {
        $this->objectHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
    }

    public function test_Should_Return_Corret_Form_Action()
    {
        $urlInterface = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $urlInterface->expects($this->once())
            ->method('getUrl')
            ->with('testimonials/index/save')
            ->willReturn('http://mage.local/testimonials/index/save');

        $contextMock = $this->getMockBuilder(\Magento\Framework\View\Element\Template\Context::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUrlBuilder'])
            ->getMock();

        $contextMock->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($urlInterface);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'context' => $contextMock
        ]);

        $urlAction = $formBlockObj->getFormAction();

        $this->assertEquals('http://mage.local/testimonials/index/save', $urlAction);
    }

    public function test_Should_Return_True_If_Module_Is_Enabled()
    {
        $configHelper = $this->getConfigHelperMock([
            'method' => 'isEnabled',
            'return' => true
        ]);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'configHelper' => $configHelper,
        ]);

        $this->assertTrue($formBlockObj->isEnabled());
    }

    public function test_Should_Return_True_If_Designation_Is_Enabled()
    {
        $configHelper = $this->getConfigHelperMock([
            'method' => 'isDesignationEnabled',
            'return' => true
        ]);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'configHelper' => $configHelper,
        ]);

        $this->assertTrue($formBlockObj->isDesignationEnabled());
    }

    public function test_Should_Return_True_If_Company_Is_Enabled()
    {
        $configHelper = $this->getConfigHelperMock([
            'method' => 'isCompanyEnabled',
            'return' => true
        ]);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'configHelper' => $configHelper,
        ]);

        $this->assertTrue($formBlockObj->isCompanyEnabled());
    }

    public function test_Should_Return_True_If_Email_Is_Enabled()
    {
        $configHelper = $this->getConfigHelperMock([
            'method' => 'isEmailEnabled',
            'return' => true
        ]);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'configHelper' => $configHelper,
        ]);

        $this->assertTrue($formBlockObj->isEmailEnabled());
    }

    public function test_Should_Return_True_If_Picture_Is_Enabled()
    {
        $configHelper = $this->getConfigHelperMock([
            'method' => 'isPictureEnabled',
            'return' => true
        ]);

        $formBlockObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Block\Widget\Form::class, [
            'configHelper' => $configHelper,
        ]);

        $this->assertTrue($formBlockObj->isPictureEnabled());
    }

    private function getConfigHelperMock($parameters = [])
    {
        $configHelper = $this->getMockBuilder(PauloVictorDev\Testimonials\Helper\Config::class)
            ->disableOriginalConstructor()
            ->setMethods([$parameters['method']])
            ->getMock();

        $configHelper->expects($this->once())
            ->method($parameters['method'])
            ->willReturn($parameters['return']);

        return $configHelper;
    }
}
