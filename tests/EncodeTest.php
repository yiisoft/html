<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use Yiisoft\Html\Html;

final class EncodeTest extends TestCase
{
    private function dataEncode(string $context): array
    {
        $items = [
            [
                'value' => "a \t=<>&\"'\x80\u{20bd}`\u{000a}\u{000c}\u{0000}",
                'result' => [
                    'content' => "a \t=&lt;&gt;&amp;\"'�₽`\n\u{000c}\u{0000}",
                    'attribute' => "a&#32;&Tab;&equals;&lt;&gt;&amp;&quot;&apos;�₽&grave;&NewLine;&#12;&#0;",
                    'quotedAttribute' => "a \t=&lt;&gt;&amp;&quot;&apos;�₽`\n\u{000c}&#0;",
                ],
            ],
            [
                'value' => '<b>test</b>',
                'result' => [
                    'content' => '&lt;b&gt;test&lt;/b&gt;',
                    'attribute' => '&lt;b&gt;test&lt;/b&gt;',
                    'quotedAttribute' => '&lt;b&gt;test&lt;/b&gt;',
                ],
            ],
            [
                'value' => '"hello"',
                'result' => [
                    'content' => '"hello"',
                    'attribute' => '&quot;hello&quot;',
                    'quotedAttribute' => '&quot;hello&quot;',
                ],
            ],
            [
                'value' => "'hello world'",
                'result' => [
                    'content' => "'hello world'",
                    'attribute' => "&apos;hello&#32;world&apos;",
                    'quotedAttribute' => "&apos;hello world&apos;",
                ],
            ],
            [
                'value' => 'Chip&amp;Dale',
                'result' => [
                    'content' => 'Chip&amp;amp;Dale',
                    'attribute' => 'Chip&amp;amp;Dale',
                    'quotedAttribute' => 'Chip&amp;amp;Dale',
                ],
            ],
            [
                'value' => "\t\$x=24;",
                'result' => [
                    'content' => "\t\$x=24;",
                    'attribute' => '&Tab;$x&equals;24;',
                    'quotedAttribute' => "\t\$x=24;",
                ],
            ],
            [
                'value' => 36.6,
                'result' => [
                    'content' => '36.6',
                    'attribute' => '36.6',
                    'quotedAttribute' => '36.6',
                ],
            ],
        ];

        $result = [];
        foreach ($items as $item) {
            $result[] = [$item['value'], $item['result'][$context]];
        }

        return $result;
    }

    public function dataEncodeContent(): array
    {
        return $this->dataEncode('content');
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

    public function testEncodeContentPreventDoubleEncode(): void
    {
        $this->assertSame('Chip&amp;Dale &gt;', Html::encodeContent('Chip&amp;Dale >', false));
    }

    public function dataEncodeAttribute(): array
    {
        return $this->dataEncode('attribute');
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

    public function testEncodeAttributePreventDoubleEncode(): void
    {
        $this->assertSame('Chip&amp;Dale&#32;&gt;', Html::encodeAttribute('Chip&amp;Dale >', false));
    }

    public function dataEncodeQuotedAttribute(): array
    {
        return $this->dataEncode('quotedAttribute');
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

    public function testEncodeQuotedAttributePreventDoubleEncode(): void
    {
        $this->assertSame('Chip&amp;Dale &gt;', Html::encodeQuotedAttribute('Chip&amp;Dale >', false));
    }
}
