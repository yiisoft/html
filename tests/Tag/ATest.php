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

    public function dataRel(): array
    {
        return [
            ['<a></a>', null],
            ['<a rel="nofollow"></a>', 'nofollow'],
            ['<a rel="noopener"></a>', 'noopener'],
            ['<a rel="noreferrer"></a>', 'noreferrer'],
            ['<a rel="nofollow noopener noreferrer"></a>', 'nofollow noopener noreferrer'],
        ];
    }

    /**
     * @dataProvider dataTarget
     */
    public function testRel(string $expected, ?string $contextName): void
    {
        self::assertSame($expected, (string)A::tag()->target($contextName));
    }

    public function dataTarget(): array
    {
        return [
            ['<a></a>', null],
            ['<a target="_blank"></a>', '_blank'],
        ];
    }

    /**
     * @dataProvider dataTarget
     */
    public function testTarget(string $expected, ?string $contextName): void
    {
        self::assertSame($expected, (string)A::tag()->target($contextName));
    }

    public function testImmutability(): void
    {
        $tag = A::tag();
        self::assertNotSame($tag, $tag->content(''));
        self::assertNotSame($tag, $tag->href(null));
        self::assertNotSame($tag, $tag->url(null));
        self::assertNotSame($tag, $tag->mailto(null));
        self::assertNotSame($tag, $tag->target(null));
    }
}
