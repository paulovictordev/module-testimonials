<?php

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    protected $objectHelper;

    public function setUp()
    {
        $this->objectHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
    }

    public function test_Should_Return_True_If_Module_Is_Enabled()
    {
        $scopeConfigTrue = $this->setScopeConfigExpected([
            [
                'config' => 'general/enable',
                'return' => true
            ]
        ]);

        $configObjTrue = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigTrue,
        ]);

        $scopeConfigFalse = $this->setScopeConfigExpected([
            [
                'config' => 'general/enable',
                'return' => false
            ]
        ]);

        $configObjFalse = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigFalse,
        ]);

        $this->assertTrue($configObjTrue->isEnabled());
        $this->assertFalse($configObjFalse->isEnabled());
    }

    public function test_Should_Return_True_If_Designation_Is_Enabled()
    {
        $scopeConfigTrue = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_designation',
                'return' => true
            ]
        ]);

        $configObjTrue = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigTrue,
        ]);

        $scopeConfigFalse = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_designation',
                'return' => false
            ]
        ]);

        $configObjFalse = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigFalse,
        ]);

        $this->assertTrue($configObjTrue->isDesignationEnabled());
        $this->assertFalse($configObjFalse->isDesignationEnabled());
    }

    public function test_Should_Return_True_If_Company_Is_Enabled()
    {
        $scopeConfigTrue = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_company',
                'return' => true
            ]
        ]);

        $configObjTrue = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigTrue,
        ]);

        $scopeConfigFalse = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_company',
                'return' => false
            ]
        ]);

        $configObjFalse = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigFalse,
        ]);

        $this->assertTrue($configObjTrue->isCompanyEnabled());
        $this->assertFalse($configObjFalse->isCompanyEnabled());
    }

    public function test_Should_Return_True_If_Email_Is_Enabled()
    {
        $scopeConfigTrue = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_email',
                'return' => true
            ]
        ]);

        $configObjTrue = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigTrue,
        ]);

        $scopeConfigFalse = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_email',
                'return' => false
            ]
        ]);

        $configObjFalse = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigFalse,
        ]);

        $this->assertTrue($configObjTrue->isEmailEnabled());
        $this->assertFalse($configObjFalse->isEmailEnabled());
    }

    public function test_Should_Return_True_If_Picture_Is_Enabled()
    {
        $scopeConfigTrue = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_picture',
                'return' => true
            ]
        ]);

        $configObjTrue = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigTrue,
        ]);

        $scopeConfigFalse = $this->setScopeConfigExpected([
            [
                'config' => 'form/enable_picture',
                'return' => false
            ]
        ]);

        $configObjFalse = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfigFalse,
        ]);

        $this->assertTrue($configObjTrue->isPictureEnabled());
        $this->assertFalse($configObjFalse->isPictureEnabled());
    }

    public function test_Should_Return_Configured_Message_Text()
    {
        $scopeConfig = $this->setScopeConfigExpected([
            [
                'config' => 'form/submit_message',
                'return' => 'Thanks for your testimonial.'
            ]
        ]);

        $configObj = $this->objectHelper->getObject(PauloVictorDev\Testimonials\Helper\Config::class, [
            'scopeConfig' => $scopeConfig,
        ]);

        $this->assertTrue(is_string($configObj->getSubmitMessage()));
        $this->assertEquals('Thanks for your testimonial.', $configObj->getSubmitMessage());
    }

    private function mockScopeConfig()
    {
        return $this->getMockBuilder(
            \Magento\Framework\App\Config\ScopeConfigInterface::class
        )->getMock();
    }

    private function setScopeConfigExpected($configs = [])
    {
        $scopeConfigMock = $this->mockScopeConfig();

        foreach ($configs as $config) {
            extract($config);

            if (isset($sequence) && is_int($sequence)) {
                $scopeConfigMock->expects($this->at($sequence))
                    ->method('getValue')
                    ->with('testimonial/' . $config)
                    ->willReturn($return);
            } else {
                $scopeConfigMock->method('getValue')
                    ->with('testimonial/' . $config)
                    ->willReturn($return);
            }
        }

        return $scopeConfigMock;
    }
}
