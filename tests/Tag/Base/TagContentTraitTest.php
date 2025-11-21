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
            TestTagContentTrait::tag()
                ->id('main')
                ->content('<b>hello &gt; world!</b>')
                ->render(),
        );
    }

    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<test><b>hello</b></test>',
            (string) TestTagContentTrait::tag()
                ->content('<b>hello</b>')
                ->encode(false),
        );
    }

    public function testWithoutDoubleEncode(): void
    {
        $this->assertSame(
            '<test>&lt;b&gt;A &gt; B&lt;/b&gt;</test>',
            (string) TestTagContentTrait::tag()
                ->content('<b>A &gt; B</b>')
                ->doubleEncode(false),
        );
    }

    public static function dataContent(): array
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

    #[DataProvider('dataContent')]
    public function testContent(string $expected, string|array|Stringable $content): void
    {
        $tag = TestTagContentTrait::tag();
        $tag = is_array($content) ? $tag->content(...$content) : $tag->content($content);

        $this->assertSame($expected, $tag->render());
    }

    public function testEncodeContent(): void
    {
        $this->assertSame(
            '<test>&lt;p&gt;Hi!&lt;/p&gt;</test>',
            TestTagContentTrait::tag()
                ->encode(true)
                ->content(P::tag()->content('Hi!'))
                ->render(),
        );
    }

    public function testAddContent(): void
    {
        $this->assertSame(
            '<test>Hello World</test>',
            TestTagContentTrait::tag()
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
            TestTagContentTrait::tag()
                ->content('1')
                ->addContent(...['2', '3'])
                ->render(),
        );
    }

    public function testNamedParametersContent(): void
    {
        $this->assertSame(
            '<test>123</test>',
            TestTagContentTrait::tag()
                ->content(content: '1')
                ->addContent(content: '2')
                ->addContent(content: '3')
                ->render(),
        );
    }

    public function testContentArray(): void
    {
        $tag = TestTagContentTrait::tag()->content(a: '1', b: '2');

        $this->assertSame(['1', '2'], $tag->getContentArray());
    }

    public function testImmutability(): void
    {
        $tag = TestTagContentTrait::tag();
        $this->assertNotSame($tag, $tag->encode(true));
        $this->assertNotSame($tag, $tag->doubleEncode(true));
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->addContent(''));
    }
}
