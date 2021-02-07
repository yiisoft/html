<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestContainerTag;

final class ContainerTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">content</test>',
            (string)TestContainerTag::tag()->id('main')
        );
    }
}
