<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Objects\TestTagContentTrait;

use function is_array;

final class TagContentTraitTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test id="main">&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;</test>',
            (new TestTagContentTrait())
                ->id('main')
                ->content('<b>hello &gt; world!</b>')
                ->render(),
        );
    }

    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<test><b>hello</b></test>',
            (string) (new TestTagContentTrait())
                ->content('<b>hello</b>')
                ->encode(false),
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        $this->assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string) (new TestTagContentTrait())
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
            'int' => ['<test>42</test>', 42],
            'float' => ['<test>3.14</test>', 3.14],
            'null' => ['<test></test>', null],
        ];
    }

    #[DataProvider('dataContent')]
    public function testContent(string $expected, string|int|float|array|Stringable|null $content): void
    {
        $tag = new TestTagContentTrait();
        $tag = is_array($content) ? $tag->content(...$content) : $tag->content($content);

        $this->assertSame($expected, $tag->render());
    }

    public function testEncodeContent(): void
    {
        $this->assertSame(
            '<test>&lt;p&gt;Hi!&lt;/p&gt;</test>',
            (new TestTagContentTrait())
                ->encode(true)
                ->content((new P())->content('Hi!'))
                ->render(),
        );
    }

    public static function dataAddContent(): array
    {
        return [
            'stringable' => [
                '<test>Hello World</test>',
                'Hello',
                [' ', new StringableObject('World')],
            ],
            'int' => [
                '<test>Value: 42</test>',
                'Value: ',
                [42],
            ],
            'float' => [
                '<test>Value: 3.14</test>',
                'Value: ',
                [3.14],
            ],
        ];
    }

    #[DataProvider('dataAddContent')]
    public function testAddContent(string $expected, string $initial, array $additions): void
    {
        $tag = (new TestTagContentTrait())->content($initial);
        foreach ($additions as $addition) {
            $tag = $tag->addContent($addition);
        }

        $this->assertSame($expected, $tag->render());
    }

    public function testAddContentVariadic(): void
    {
        $this->assertSame(
            '<test>123</test>',
            (new TestTagContentTrait())
                ->content('1')
                ->addContent(...['2', '3'])
                ->render(),
        );
    }

    public function testNamedParametersContent(): void
    {
        $this->assertSame(
            '<test>123</test>',
            (new TestTagContentTrait())
                ->content(content: '1')
                ->addContent(content: '2')
                ->addContent(content: '3')
                ->render(),
        );
    }

    public static function dataContentArray(): array
    {
        return [
            'strings' => [['1', '2'], ['a' => '1', 'b' => '2']],
            'int-float-null' => [[42, 3.14, null], ['a' => 42, 'b' => 3.14, 'c' => null]],
        ];
    }

    #[DataProvider('dataContentArray')]
    public function testContentArray(array $expected, array $args): void
    {
        $tag = (new TestTagContentTrait())->content(...$args);

        $this->assertSame($expected, $tag->getContentArray());
    }

    public function testImmutability(): void
    {
        $tag = new TestTagContentTrait();
        $this->assertNotSame($tag, $tag->encode(true));
        $this->assertNotSame($tag, $tag->doubleEncode(true));
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->addContent(''));
    }
}
