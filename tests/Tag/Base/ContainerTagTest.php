<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestContainerTag;

final class ContainerTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="main">content</test>',
            TestContainerTag::tag()->id('main')->render()
        );
    }

    public function testOpen(): void
    {
        self::assertSame(
            '<test id="main">',
            TestContainerTag::tag()->id('main')->open(),
        );
    }

    public function testClose(): void
    {
        self::assertSame(
            '</test>',
            TestContainerTag::tag()->id('main')->close(),
        );
    }
}
