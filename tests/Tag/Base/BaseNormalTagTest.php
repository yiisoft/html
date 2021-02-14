<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestBaseNormalTag;

final class BaseNormalTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="main">&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;</test>',
            TestBaseNormalTag::tag()->id('main')->content('<b>hello &gt; world!</b>')->render()
        );
    }

    public function testWithoutEncode(): void
    {
        self::assertSame(
            '<test><b>hello</b></test>',
            (string)TestBaseNormalTag::tag()->content('<b>hello</b>')->withoutEncode()
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        self::assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string)TestBaseNormalTag::tag()->content('<b>A &gt; B</b>')->withoutDoubleEncode()
        );
    }

    public function testContent(): void
    {
        self::assertSame(
            '<test>hello</test>',
            (string)TestBaseNormalTag::tag()->content('hello')
        );
    }

    public function testOpen(): void
    {
        self::assertSame(
            '<test id="main">',
            TestBaseNormalTag::tag()->id('main')->open(),
        );
    }

    public function testClose(): void
    {
        self::assertSame(
            '</test>',
            TestBaseNormalTag::tag()->id('main')->close(),
        );
    }

    public function testImmutability(): void
    {
        $tag = TestBaseNormalTag::tag();
        self::assertNotSame($tag, $tag->withoutEncode());
        self::assertNotSame($tag, $tag->withoutDoubleEncode());
        self::assertNotSame($tag, $tag->content(''));
    }
}
