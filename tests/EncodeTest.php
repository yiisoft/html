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
            ["'hello'", "'hello'"],
            ['Chip&amp;Dale', 'Chip&amp;amp;Dale'],
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
            ["a <>&\"'\x80\u{20bd}`", "a &lt;&gt;&amp;&quot;&apos;�₽`"],
            ['<b>test</b>', '&lt;b&gt;test&lt;/b&gt;'],
            ['"hello"', '&quot;hello&quot;'],
            ["'hello'", "&apos;hello&apos;"],
            ['Chip&amp;Dale', 'Chip&amp;amp;Dale'],
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
}
