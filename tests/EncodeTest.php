<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use Yiisoft\Html\Html;

final class EncodeTest extends TestCase
{
    public function dataEncodeContent(): array
    {
        return [
            ["a <>&\"'\x80\u{20bd}`", "a &lt;&gt;&amp;\"'�₽`"],
            ['<b>test</b>', '&lt;b&gt;test&lt;/b&gt;'],
            ['"hello"', '"hello"'],
            ["'hello world'", "'hello world'"],
            ['Chip&amp;Dale', 'Chip&amp;amp;Dale'],
            [36.6, '36.6'],
        ];
    }

    /**
     * @dataProvider dataEncodeContent
     *
     * @param mixed $content
     * @param string $expected
     */
    public function testEncodeContent($content, string $expected): void
    {
        $this->assertSame($expected, Html::encodeContent($content));
    }

    public function dataEncodeAttribute(): array
    {
        return [
            ["a <>&\"'\x80\u{20bd}`", "a&#32;&lt;&gt;&amp;&quot;&apos;�₽&grave;"],
            ['<b>test</b>', '&lt;b&gt;test&lt;/b&gt;'],
            ['"hello"', '&quot;hello&quot;'],
            ["'hello world'", "&apos;hello&#32;world&apos;"],
            ['Chip&amp;Dale', 'Chip&amp;amp;Dale'],
            [36.6, '36.6'],
        ];
    }

    /**
     * @dataProvider dataEncodeAttribute
     *
     * @param mixed $content
     * @param string $expected
     */
    public function testEncodeAttribute($content, string $expected): void
    {
        $this->assertSame($expected, Html::encodeAttribute($content));
    }

    public function dataEncodeQuotedAttribute(): array
    {
        return [
            ["a <>&\"'\x80\u{20bd}`", "a &lt;&gt;&amp;&quot;&apos;�₽`"],
            ['<b>test</b>', '&lt;b&gt;test&lt;/b&gt;'],
            ['"hello"', '&quot;hello&quot;'],
            ["'hello world'", "&apos;hello world&apos;"],
            ['Chip&amp;Dale', 'Chip&amp;amp;Dale'],
            [36.6, '36.6'],
        ];
    }

    /**
     * @dataProvider dataEncodeQuotedAttribute
     *
     * @param mixed $content
     * @param string $expected
     */
    public function testEncodeQuotedAttribute($content, string $expected): void
    {
        $this->assertSame($expected, Html::encodeQuotedAttribute($content));
    }
}
