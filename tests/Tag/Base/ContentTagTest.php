<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Span;
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

    public function testWithoutDoubleEncode(): void
    {
        self::assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string)TestContentTag::tag()->content('<b>A &gt; B</b>')->doubleEncode(false)
        );
    }

    public function dataContent(): array
    {
        return [
            'string' => ['<test>hello</test>', 'hello'],
            'string-tag' => ['<test>&lt;p&gt;Hi!&lt;/p&gt;</test>', '<p>Hi!</p>'],
            'object-tag' => ['<test><p>Hi!</p></test>', P::tag()->content('Hi!')],
            'array' => [
                '<test>Hello &gt; <span>World</span>!</test>',
                ['Hello', ' > ', Span::tag()->content('World'), '!'],
            ],
        ];
    }

    /**
     * @dataProvider dataContent
     *
     * @param string|Stringable|string[]|Stringable[] $content
     */
    public function testContent(string $expected, $content): void
    {
        self::assertSame($expected, TestContentTag::tag()->content($content)->render());
    }

    public function testEncodeContent(): void
    {
        self::assertSame(
            '<test>&lt;p&gt;Hi!&lt;/p&gt;</test>',
            TestContentTag::tag()
                ->encode(true)
                ->content(P::tag()->content('Hi!'))
                ->render()
        );
    }

    public function testImmutability(): void
    {
        $tag = TestContentTag::tag();
        self::assertNotSame($tag, $tag->encode(true));
        self::assertNotSame($tag, $tag->doubleEncode(true));
        self::assertNotSame($tag, $tag->content(''));
    }
}
