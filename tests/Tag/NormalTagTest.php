<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestNormalTag;

final class NormalTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">&lt;b&gt;hello&lt;/b&gt;</test>',
            (string)TestNormalTag::tag()->id('main')->content('<b>hello</b>')
        );
    }

    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<test><b>hello</b></test>',
            (string)TestNormalTag::tag()->content('<b>hello</b>')->withoutEncode()
        );
    }

    public function testContent(): void
    {
        $this->assertSame(
            '<test>hello</test>',
            (string)TestNormalTag::tag()->content('hello')
        );
    }

    public function testImmutability(): void
    {
        $tag = TestNormalTag::tag();
        $this->assertNotSame($tag, $tag->withoutEncode());
        $this->assertNotSame($tag, $tag->content(''));
    }
}
