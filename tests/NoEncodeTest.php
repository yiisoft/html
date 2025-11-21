<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\NoEncode;
use Yiisoft\Html\NoEncodeStringableInterface;

final class NoEncodeTest extends TestCase
{
    public function testBase(): void
    {
        $object = NoEncode::string('test');

        $this->assertInstanceOf(NoEncodeStringableInterface::class, $object);
        $this->assertSame('test', (string) $object);
    }
}
