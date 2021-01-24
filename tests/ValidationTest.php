<?php

// tests use framework classes...
// require __DIR__ . '/../vendor/autoload.php';

// validation manager uses $_SESSION...
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use Framework\Validation\Manager;
use Framework\Validation\Rule\RequiredRule;
use Framework\Validation\Rule\EmailRule;
use Framework\Validation\Rule\MinRule;
use Framework\Validation\ValidationException;

// class ValidationTest extends \PHPUnit\Framework\TestCase
class ValidationTest extends Framework\Testing\TestCase
{
    protected Manager $manager;

    public function setUp(): void
    {
        parent::setUp();

        $this->manager = new Manager();
        $this->manager->addRule('email', new EmailRule());
    }

    public function testInvalidEmailValuesFail()
    {
        $expected = ['email' => ['email should be an email']];

        // try {
            
        // }
        // catch (Throwable $e) {
        //     assert($e instanceof ValidationException, 'error should be thrown');
        //     assert($e->getErrors()['email'] === $expected['email'], 'messages should match');
        //     return;
        // }

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->manager->validate(['email' => 'foo'], ['email' => ['email']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());

        // throw new Exception('validation did not fail');
    }

    public function testValidEmailValuesPass()
    {
        // try {
        //     $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['email']]);
        // }
        // catch (Throwable $e) {
        //     throw new Exception('validation did failed');
        //     return;
        // }

        $data = $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['email']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }
}

// $test = new ValidationTest();
// $test->testInvalidEmailValuesFail();
// $test->testValidEmailValuesPass();

// print 'All tests passed' . PHP_EOL;
