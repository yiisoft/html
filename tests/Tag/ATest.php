<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\A;

final class ATest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<a href="https://example.com">Link</a>',
            (string)A::tag()->url('https://example.com')->content('Link')
        );
    }

    public function dataHref(): array
    {
        return [
            ['<a></a>', null],
            ['<a href="https://example.com"></a>', 'https://example.com'],
        ];
    }

    /**
     * @dataProvider dataHref
     */
    public function testHref(string $expected, ?string $href): void
    {
        $this->assertSame($expected, (string)A::tag()->href($href));
    }

    public function dataUrl(): array
    {
        return [
            ['<a></a>', null],
            ['<a href="https://example.com"></a>', 'https://example.com'],
        ];
    }

    /**
     * @dataProvider dataUrl
     */
    public function testUrl(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string)A::tag()->url($url));
    }

    public function dataMailto(): array
    {
        return [
            ['<a></a>', null],
            ['<a href="mailto:contact@example.com"></a>', 'contact@example.com'],
        ];
    }

    /**
     * @dataProvider dataMailto
     */
    public function testMailto(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string)A::tag()->mailto($url));
    }

    public function testImmutability(): void
    {
        $tag = A::tag();
        $this->assertNotSame($tag, $tag->href(null));
        $this->assertNotSame($tag, $tag->url(null));
        $this->assertNotSame($tag, $tag->mailto(null));
    }
}
