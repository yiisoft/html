<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use Yiisoft\Html\Tests\Objects\TestVoidTag;
use Yiisoft\Html\Tests\TestCase;

final class VoidTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">',
            (string)TestVoidTag::tag()->id('main')
        );
    }
}
