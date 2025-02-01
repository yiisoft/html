<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Ms;

final class MsTest extends TestCase
{
    public function testHelloWorld(): void
    {
        $ms = Ms::tag()->content('Hello World');

        $this->assertSame('<ms>Hello World</ms>', (string) $ms);
    }
}
