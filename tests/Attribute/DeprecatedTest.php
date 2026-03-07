<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Attribute\Deprecated;

final class DeprecatedTest extends TestCase
{
    private function make(?string $message, ?string $since): Deprecated
    {
        $errors = [];
        set_error_handler(static function (int $errno, string $errstr) use (&$errors): bool {
            $errors[] = $errstr;
            return true;
        }, E_USER_DEPRECATED);

        $attribute = new Deprecated($message, $since);

        restore_error_handler();

        return $attribute;
    }

    public function testMessageProperty(): void
    {
        $attribute = $this->make('Test message', null);

        $this->assertSame('Test message', $attribute->message);
    }

    public function testSinceProperty(): void
    {
        $attribute = $this->make('Test message', '1.0.0');

        $this->assertSame('1.0.0', $attribute->since);
    }

    public function testNullMessageProperty(): void
    {
        $attribute = $this->make(null, null);

        $this->assertNull($attribute->message);
    }

    public function testNullSinceProperty(): void
    {
        $attribute = $this->make('Test message', null);

        $this->assertNull($attribute->since);
    }

    public function testTriggersDeprecationError(): void
    {
        $triggered = false;
        $triggeredMessage = null;

        set_error_handler(static function (int $errno, string $errstr) use (&$triggered, &$triggeredMessage): bool {
            $triggered = true;
            $triggeredMessage = $errstr;
            return true;
        }, E_USER_DEPRECATED);

        new Deprecated('Use something else.', null);

        restore_error_handler();

        $this->assertTrue($triggered);
        $this->assertSame('Use something else.', $triggeredMessage);
    }

    public function testNullMessageTriggersEmptyError(): void
    {
        $triggeredMessage = null;

        set_error_handler(static function (int $errno, string $errstr) use (&$triggeredMessage): bool {
            $triggeredMessage = $errstr;
            return true;
        }, E_USER_DEPRECATED);

        new Deprecated(null, null);

        restore_error_handler();

        $this->assertSame('', $triggeredMessage);
    }

    public function testClassAlias(): void
    {
        $this->assertTrue(class_exists('Deprecated'));

        $attribute = $this->make('Test message', null);

        $this->assertInstanceOf(Deprecated::class, $attribute);
    }
}