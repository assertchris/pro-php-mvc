<?php

use Framework\Testing\TestCase;
use Framework\Testing\TestResponse;

class RoutingTest extends TestCase
{
    public function testHomePageIsShown()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $expected = 'Take a trip on a rocket ship';

        $this->assertStringContainsString($expected, app()->run()->content());
    }

    public function testRegistrationErrorsAreShown()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/register';
        $_SERVER['HTTP_REFERER'] = '/register';

        $_POST['email'] = 'foo';
        $_POST['csrf'] = csrf();

        $response = new TestResponse(app()->run());

        $this->assertTrue($response->isRedirecting());
        $this->assertEquals($response->redirectingTo(), '/register');
    }
}
