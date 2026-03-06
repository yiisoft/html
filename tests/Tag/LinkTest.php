<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Link;

final class LinkTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<link type="application/rss+xml" href="/rss" title="Новости компании" rel="alternate">',
            (string) new Link()
                ->url('/rss')
                ->type('application/rss+xml')
                ->rel('alternate')
                ->title('Новости компании'),
        );
    }

    public function testToCssFile(): void
    {
        $this->assertSame(
            '<link href="main.css" rel="stylesheet">',
            (string) Link::toCssFile('main.css'),
        );
    }

    public static function dataUrl(): array
    {
        return [
            ['<link>', null],
            ['<link href="main.css">', 'main.css'],
        ];
    }

    #[DataProvider('dataUrl')]
    public function testUrl(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) (new Link())->url($url));
        $this->assertSame($expected, (string) (new Link())->href($url));
    }

    public static function dataRel(): array
    {
        return [
            ['<link>', null],
            ['<link rel="preload">', 'preload'],
        ];
    }

    #[DataProvider('dataRel')]
    public function testRel(string $expected, ?string $rel): void
    {
        $this->assertSame($expected, (string) (new Link())->rel($rel));
    }

    public static function dataType(): array
    {
        return [
            ['<link>', null],
            ['<link type="application/rss+xml">', 'application/rss+xml'],
        ];
    }

    #[DataProvider('dataType')]
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string) (new Link())->type($type));
    }

    public static function dataTitle(): array
    {
        return [
            ['<link>', null],
            ['<link title="Блог">', 'Блог'],
        ];
    }

    #[DataProvider('dataTitle')]
    public function testTitle(string $expected, ?string $title): void
    {
        $this->assertSame($expected, (string) (new Link())->title($title));
    }

    public static function dataCrossOrigin(): array
    {
        return [
            ['<link>', null],
            ['<link crossorigin="anonymous">', 'anonymous'],
        ];
    }

    #[DataProvider('dataCrossOrigin')]
    public function testCrossOrigin(string $expected, ?string $crossOrigin): void
    {
        $this->assertSame($expected, (string) (new Link())->crossOrigin($crossOrigin));
    }

    public static function dataTestAs(): array
    {
        return [
            ['<link>', null],
            ['<link as>', ''],
            ['<link as="video">', 'video'],
        ];
    }

    #[DataProvider('dataTestAs')]
    public function testAs(string $expected, ?string $as): void
    {
        $this->assertSame($expected, (string) (new Link())->as($as));
    }

    public static function dataPreload(): array
    {
        return [
            ['<link href="/main.css" rel="preload">', '/main.css'],
            ['<link href="/main.css" rel="preload" as="style">', '/main.css', 'style'],
        ];
    }

    #[DataProvider('dataPreload')]
    public function testPreload(string $expected, string $url, ?string $as = null): void
    {
        $tag = $as === null
            ? (new Link())->preload($url)
            : (new Link())->preload($url, $as);

        $this->assertSame($expected, $tag->render());
    }

    public function testImmutability(): void
    {
        $link = new Link();
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
