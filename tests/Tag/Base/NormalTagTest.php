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
            '<test id="main">&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;</test>',
            TestNormalTag::tag()->id('main')->content('<b>hello &gt; world!</b>')->render()
        );
    }

    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<test><b>hello</b></test>',
            (string)TestNormalTag::tag()->content('<b>hello</b>')->withoutEncode()
        );
    }

    public function testPreventDoubleEncode(): void
    {
        $this->assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string)TestNormalTag::tag()->content('<b>A &gt; B</b>')->preventDoubleEncode()
        );
    }

    public function testContent(): void
    {
        $this->assertSame(
            '<test>hello</test>',
            (string)TestNormalTag::tag()->content('hello')
        );
    }

    public function testBegin(): void
    {
        self::assertSame(
            '<test id="main">',
            TestNormalTag::tag()->id('main')->begin(),
        );
    }

    public function testEnd(): void
    {
        self::assertSame(
            '</test>',
            TestNormalTag::tag()->id('main')->end(),
        );
    }

    public function testImmutability(): void
    {
        $tag = TestNormalTag::tag();
        $this->assertNotSame($tag, $tag->withoutEncode());
        $this->assertNotSame($tag, $tag->preventDoubleEncode());
        $this->assertNotSame($tag, $tag->content(''));
    }
}
