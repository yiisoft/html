<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestNormalTag;

final class NormalTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="main">&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;</test>',
            TestNormalTag::tag()->id('main')->content('<b>hello &gt; world!</b>')->render()
        );
    }
}
