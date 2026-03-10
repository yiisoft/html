<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Html\Tests\Objects\StringableObject;

use function is_array;

final class CustomTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="custom" count="15">body</test>',
            (new CustomTag('test'))
                ->id('custom')
                ->attribute('count', 15)
                ->content('body')
                ->render(),
        );
    }

    public static function dataVoidTags(): array
    {
        return [
            ['area'],
            ['AREA'],
            ['br'],
            ['hr'],
        ];
    }

    #[DataProvider('dataVoidTags')]
    public function testVoidTags(string $name): void
    {
        $this->assertSame(
            "<$name>",
            (new CustomTag($name))->render(),
        );
    }

    public static function dataNormal(): array
    {
        return [
            ['<h1></h1>', 'h1'],
            ['<col></col>', 'col'],
        ];
    }

    #[DataProvider('dataNormal')]
    public function testNormal(string $expected, string $name): void
    {
        $this->assertSame($expected, (new CustomTag($name))
            ->normal()
            ->render());
    }

    public static function dataVoid(): array
    {
        return [
            ['<h1>', 'h1'],
            ['<col>', 'col'],
        ];
    }

    #[DataProvider('dataVoid')]
    public function testVoid(string $expected, string $name): void
    {
        $this->assertSame($expected, (new CustomTag($name))
            ->void()
            ->render());
    }

    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<test><b>hello</b></test>',
            (string) (new CustomTag('test'))
                ->content('<b>hello</b>')
                ->encode(false),
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        $this->assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string) (new CustomTag('test'))
                ->content('<b>A &gt; B</b>')
                ->doubleEncode(false),
        );
    }

    public static function dataContent(): array
    {
        return [
            'string' => ['<test>hello</test>', 'hello'],
            'string-tag' => ['<test>&lt;p&gt;Hi!&lt;/p&gt;</test>', '<p>Hi!</p>'],
            'object-tag' => ['<test><p>Hi!</p></test>', (new P())->content('Hi!')],
            'array' => [
                '<test>Hello &gt; <span>World</span>!</test>',
                ['Hello', ' > ', (new Span())->content('World'), '!'],
            ],
        ];
    }

    #[DataProvider('dataContent')]
    public function testContent(string $expected, string|array|Stringable $content): void
    {
        $tag = new CustomTag('test');
        $tag = is_array($content) ? $tag->content(...$content) : $tag->content($content);

        $this->assertSame($expected, $tag->render());
    }

    public function testEncodeContent(): void
    {
        $this->assertSame(
            '<test>&lt;p&gt;Hi!&lt;/p&gt;</test>',
            (new CustomTag('test'))
                ->encode(true)
                ->content((new P())->content('Hi!'))
                ->render(),
        );
    }

    public function testAddContent(): void
    {
        $this->assertSame(
            '<test>Hello World</test>',
            (new CustomTag('test'))
                ->content('Hello')
                ->addContent(' ')
                ->addContent(new StringableObject('World'))
                ->render(),
        );
    }

    public function testAddContentVariadic(): void
    {
        $this->assertSame(
            '<test>123</test>',
            (new CustomTag('test'))
                ->content('1')
                ->addContent(...['2', '3'])
                ->render(),
        );
    }

    public function testOpen(): void
    {
        $this->assertSame(
            '<test id="main">',
            (new CustomTag('test'))
                ->id('main')
                ->open(),
        );
    }

    public function testClose(): void
    {
        $this->assertSame(
            '</test>',
            (new CustomTag('test'))
                ->id('main')
                ->close(),
        );
    }

    public function testImmutability(): void
    {
        $tag = new CustomTag('test');
        $this->assertNotSame($tag, $tag->normal());
        $this->assertNotSame($tag, $tag->void());
        $this->assertNotSame($tag, $tag->encode(true));
        $this->assertNotSame($tag, $tag->doubleEncode(true));
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->addContent(''));
    }
}
