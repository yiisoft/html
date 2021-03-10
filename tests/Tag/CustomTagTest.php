<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\CustomTag;

final class CustomTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="custom" count="15">body</test>',
            CustomTag::name('test')->id('custom')->attribute('count', 15)->content('body')->render()
        );
    }

    public function dataVoidTags(): array
    {
        return [
            ['area'],
            ['AREA'],
            ['br'],
            ['hr'],
        ];
    }

    /**
     * @dataProvider dataVoidTags
     *
     * @psalm-param non-empty-string $name
     */
    public function testVoidTags(string $name): void
    {
        self::assertSame(
            "<$name>",
            CustomTag::name($name)->render()
        );
    }

    public function dataNormal(): array
    {
        return [
            ['<h1></h1>', 'h1'],
            ['<col></col>', 'col'],
        ];
    }

    /**
     * @dataProvider dataNormal
     *
     * @psalm-param non-empty-string $name
     */
    public function testNormal(string $expected, string $name): void
    {
        self::assertSame($expected, CustomTag::name($name)->normal()->render());
    }

    public function dataVoid(): array
    {
        return [
            ['<h1>', 'h1'],
            ['<col>', 'col'],
        ];
    }

    /**
     * @dataProvider dataVoid
     *
     * @psalm-param non-empty-string $name
     */
    public function testVoid(string $expected, string $name): void
    {
        self::assertSame($expected, CustomTag::name($name)->void()->render());
    }

    public function testWithoutEncode(): void
    {
        self::assertSame(
            '<test><b>hello</b></test>',
            (string)CustomTag::name('test')->content('<b>hello</b>')->encode(false)
        );
    }

    public function testEncodeSpaces(): void
    {
        self::assertSame(
            '<test>hello&nbsp;world</test>',
            (string)CustomTag::name('test')->content('hello world')->encodeSpaces(true)
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        self::assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string)CustomTag::name('test')->content('<b>A &gt; B</b>')->doubleEncode(false)
        );
    }

    public function testContent(): void
    {
        self::assertSame(
            '<test>hello</test>',
            (string)CustomTag::name('test')->content('hello')
        );
    }

    public function testOpen(): void
    {
        self::assertSame(
            '<test id="main">',
            CustomTag::name('test')->id('main')->open(),
        );
    }

    public function testClose(): void
    {
        self::assertSame(
            '</test>',
            CustomTag::name('test')->id('main')->close(),
        );
    }

    public function testImmutability(): void
    {
        $tag = CustomTag::name('test');
        self::assertNotSame($tag, $tag->normal());
        self::assertNotSame($tag, $tag->void());
        self::assertNotSame($tag, $tag->encode(true));
        self::assertNotSame($tag, $tag->encodeSpaces(true));
        self::assertNotSame($tag, $tag->doubleEncode(true));
        self::assertNotSame($tag, $tag->content(''));
    }
}
