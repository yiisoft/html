<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Deprecated;
use ReflectionFunction;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tests\Objects\TestNormalTag;

final class NormalTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">content</test>',
            (new TestNormalTag())
                ->id('main')
                ->render(),
        );
    }

    public function testOpen(): void
    {
        $this->assertSame(
            '<test id="main">',
            (new TestNormalTag())
                ->id('main')
                ->open(),
        );
    }

    public function testClose(): void
    {
        $this->assertSame(
            '</test>',
            (new TestNormalTag())
                ->id('main')
                ->close(),
        );
    }

    public function testDeprecation(): void
    {
        $attributes = (new ReflectionFunction(NormalTag::tag(...)))->getAttributes(Deprecated::class);
        $this->assertNotEmpty($attributes);
        $this->assertSame('Use the constructor instead.', $attributes[0]->newInstance()->message);
    }
}
