<?php

class DeviceDetectTest extends \PHPUnit_Framework_TestCase {

    public function testUserAgentCreation() {
        try {
            $deviceDetect = DeviceDetect::fromUserAgent("does not exist user agent");
            $this->fail();
        } catch (\InvalidArgumentException $e) {}

        $userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.64 Safari/537.36";
        $deviceDetect = DeviceDetect::fromUserAgent($userAgent);
        $this->assertEquals(true, $deviceDetect->isDesktop());
        $this->assertEquals("Chrome", $deviceDetect->getBrowsers()[0]->getName());
        $this->assertEquals("46.0.2490.64", $deviceDetect->getBrowsers()[0]->getVersion());
        $this->assertEquals("Macintosh", $deviceDetect->getPlatform()->getName());
        $this->assertEquals("10.10.5", $deviceDetect->getPlatform()->getVersion());
        $this->assertEquals(strtolower($userAgent), $deviceDetect->getUserAgent());
    }
    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsMobile(stdClass $meta) {
        $meta->type = "mobile";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isMobile());

        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isWatch());
        $this->assertEquals(false, $deviceDetect->isBot());
    }
    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsTablet(stdClass $meta) {
        $meta->type = "tablet";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isTablet());

        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isWatch());
        $this->assertEquals(false, $deviceDetect->isBot());
    }

    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsDesktop(stdClass $meta) {
        $meta->type = "desktop";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isDesktop());

        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isWatch());
        $this->assertEquals(false, $deviceDetect->isBot());
    }

    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsTv(stdClass $meta) {
        $meta->type = "tv";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isTv());

        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isWatch());
        $this->assertEquals(false, $deviceDetect->isBot());
    }

    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsWatch(stdClass $meta) {
        $meta->type = "watch";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isWatch());

        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isBot());
    }

    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsBot(stdClass $meta) {
        $meta->type = "bot";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isBot());

        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isWatch());
    }

    /**
     * @dataProvider providerPlatform
     */
    public function testThatPlatformIsGlass(stdClass $meta) {
        $meta->type = "glass";
        $deviceDetect = new \DeviceDetect($meta);
        $this->assertEquals(true, $deviceDetect->isGlass());

        $this->assertEquals(false, $deviceDetect->isBot());
        $this->assertEquals(false, $deviceDetect->isTablet());
        $this->assertEquals(false, $deviceDetect->isMobile());
        $this->assertEquals(false, $deviceDetect->isDesktop());
        $this->assertEquals(false, $deviceDetect->isTv());
        $this->assertEquals(false, $deviceDetect->isWatch());
    }

    public function providerPlatform() {
        return [
            [(object) [
                'name'     => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.64 Safari/537.36',
                'type'     => 'desktop',
                'platform' => [
                    'name'    => 'Macintosh',
                    'version' => '10.10.5',
                ],
                'engine'   => [
                    'name'    => 'Webkit',
                    'version' => '537.36',
                ],
                'browsers' => [
                    0 => [
                        'name'    => 'Chrome',
                        'version' => '46.0.2490.64',
                    ],
                    1 => [
                        'name'    => 'Safari',
                        'version' => '537.36',
                    ],
                ],
            ],
            ],
        ];
    }
}