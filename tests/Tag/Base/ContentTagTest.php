<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestContentTag;

final class ContentTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="main">&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;</test>',
            TestContentTag::tag()->id('main')->content('<b>hello &gt; world!</b>')->render()
        );
    }

    public function testWithoutEncode(): void
    {
        self::assertSame(
            '<test><b>hello</b></test>',
            (string)TestContentTag::tag()->content('<b>hello</b>')->encode(false)
        );
    }

    public function testEncodeSpaces(): void
    {
        self::assertSame(
            '<test>hello&nbsp;world</test>',
            (string)TestContentTag::tag()->content('hello world')->encodeSpaces(true)
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        self::assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string)TestContentTag::tag()->content('<b>A &gt; B</b>')->doubleEncode(false)
        );
    }

    public function testContent(): void
    {
        self::assertSame(
            '<test>hello</test>',
            (string)TestContentTag::tag()->content('hello')
        );
    }

    public function testOpen(): void
    {
        self::assertSame(
            '<test id="main">',
            TestContentTag::tag()->id('main')->open(),
        );
    }

    public function testClose(): void
    {
        self::assertSame(
            '</test>',
            TestContentTag::tag()->id('main')->close(),
        );
    }

    public function testImmutability(): void
    {
        $tag = TestContentTag::tag();
        self::assertNotSame($tag, $tag->encode(true));
        self::assertNotSame($tag, $tag->encodeSpaces(true));
        self::assertNotSame($tag, $tag->doubleEncode(true));
        self::assertNotSame($tag, $tag->content(''));
    }
}
