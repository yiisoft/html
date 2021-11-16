<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestVoidTag;

final class VoidTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">',
            TestVoidTag::tag()->id('main')->render()
        );
    }

    public function testGetContent(): void
    {
        $tag = TestVoidTag::tag();

        $this->assertSame('', $tag->getContent());
    }
}
