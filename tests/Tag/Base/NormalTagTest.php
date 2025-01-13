<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestNormalTag;

final class NormalTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">content</test>',
            TestNormalTag::tag()
                ->id('main')
                ->render()
        );
    }

    public function testOpen(): void
    {
        $this->assertSame(
            '<test id="main">',
            TestNormalTag::tag()
                ->id('main')
                ->open(),
        );
    }

    public function testClose(): void
    {
        $this->assertSame(
            '</test>',
            TestNormalTag::tag()
                ->id('main')
                ->close(),
        );
    }
}
