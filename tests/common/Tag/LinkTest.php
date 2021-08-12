<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Link;

final class LinkTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<link type="application/rss+xml" href="/rss" title="Новости компании" rel="alternate">',
            (string)Link::tag()
                ->url('/rss')
                ->type('application/rss+xml')
                ->rel('alternate')
                ->title('Новости компании')
        );
    }

    public function testToCssFile(): void
    {
        $this->assertSame(
            '<link href="main.css" rel="stylesheet">',
            (string)Link::toCssFile('main.css')
        );
    }

    public function dataUrl(): array
    {
        return [
            ['<link>', null],
            ['<link href="main.css">', 'main.css'],
        ];
    }

    /**
     * @dataProvider dataUrl
     */
    public function testUrl(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string)Link::tag()->url($url));
        $this->assertSame($expected, (string)Link::tag()->href($url));
    }

    public function dataRel(): array
    {
        return [
            ['<link>', null],
            ['<link rel="preload">', 'preload'],
        ];
    }

    /**
     * @dataProvider dataRel
     */
    public function testRel(string $expected, ?string $rel): void
    {
        $this->assertSame($expected, (string)Link::tag()->rel($rel));
    }

    public function dataType(): array
    {
        return [
            ['<link>', null],
            ['<link type="application/rss+xml">', 'application/rss+xml'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string)Link::tag()->type($type));
    }

    public function dataTitle(): array
    {
        return [
            ['<link>', null],
            ['<link title="Блог">', 'Блог'],
        ];
    }

    /**
     * @dataProvider dataTitle
     */
    public function testTitle(string $expected, ?string $title): void
    {
        $this->assertSame($expected, (string)Link::tag()->title($title));
    }

    public function dataCrossOrigin(): array
    {
        return [
            ['<link>', null],
            ['<link crossorigin="anonymous">', 'anonymous'],
        ];
    }

    /**
     * @dataProvider dataCrossOrigin
     */
    public function testCrossOrigin(string $expected, ?string $crossOrigin): void
    {
        $this->assertSame($expected, (string)Link::tag()->crossOrigin($crossOrigin));
    }

    public function dataTestAs(): array
    {
        return [
            ['<link>', null],
            ['<link as>', ''],
            ['<link as="video">', 'video'],
        ];
    }

    /**
     * @dataProvider dataTestAs
     */
    public function testAs(string $expected, ?string $as): void
    {
        $this->assertSame($expected, (string)Link::tag()->as($as));
    }

    public function dataPreload(): array
    {
        return [
            ['<link href="/main.css" rel="preload">', '/main.css'],
            ['<link href="/main.css" rel="preload" as="style">', '/main.css', 'style'],
        ];
    }

    /**
     * @dataProvider dataPreload
     */
    public function testPreload(string $expected, string $url, string $as = null): void
    {
        $tag = $as === null
            ? Link::tag()->preload($url)
            : Link::tag()->preload($url, $as);

        $this->assertSame($expected, $tag->render());
    }

    public function testImmutability(): void
    {
        $link = Link::tag();
        $this->assertNotSame($link, $link->url(null));
        $this->assertNotSame($link, $link->href(null));
        $this->assertNotSame($link, $link->rel(null));
        $this->assertNotSame($link, $link->type(null));
        $this->assertNotSame($link, $link->title(null));
        $this->assertNotSame($link, $link->crossOrigin(null));
        $this->assertNotSame($link, $link->as(null));
        $this->assertNotSame($link, $link->preload(''));
    }
}
