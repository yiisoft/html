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
                'value' => "a <>&\"'\x80\u{20bd}`",
                'result' => [
                    'content' => "a &lt;&gt;&amp;\"'�₽`",
                    'attribute' => "a&#32;&lt;&gt;&amp;&quot;&apos;�₽&grave;",
                    'quotedAttribute' => "a &lt;&gt;&amp;&quot;&apos;�₽`",
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
