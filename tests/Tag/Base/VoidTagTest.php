<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Deprecated;
use ReflectionFunction;
use Yiisoft\Html\Tag\Base\VoidTag;
use Yiisoft\Html\Tests\Objects\TestVoidTag;

final class VoidTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">',
            (new TestVoidTag())
                ->id('main')
                ->render(),
        );
    }

    public function testDeprecation(): void
    {
        $attributes = (new ReflectionFunction(VoidTag::tag(...)))->getAttributes(Deprecated::class);
        $this->assertNotEmpty($attributes);
        $this->assertSame('Use the constructor instead.', $attributes[0]->newInstance()->message);
    }
}
