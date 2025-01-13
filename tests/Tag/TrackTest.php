<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Track;

final class TrackTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<track src="brave.en.vtt" kind="subtitles" srclang="en" label="English">',
            (string) Track::tag()
                ->kind(Track::SUBTITLES)
                ->src('brave.en.vtt')
                ->srclang('en')
                ->label('English')
        );
    }

    public function testDefault(): void
    {
        $this->assertSame('<track default>', (string) Track::tag()->default());
        $this->assertSame('<track>', (string) Track::tag()->default(false));
        $this->assertSame('<track>', (string) Track::tag()
            ->default(true)
            ->default(false));
    }

    public function testIsDefault(): void
    {
        $this->assertFalse(Track::tag()->isDefault());
        $this->assertFalse(Track::tag()
            ->default(false)
            ->isDefault());
        $this->assertTrue(Track::tag()
            ->default()
            ->isDefault());
    }

    public static function dataKind(): array
    {
        return [
            ['<track>', null],
            ['<track kind="chapters">', Track::CHAPTERS],
        ];
    }

    #[DataProvider('dataKind')]
    public function testKind(string $expected, ?string $kind): void
    {
        $this->assertSame($expected, (string) Track::tag()->kind($kind));
    }

    public static function dataLabel(): array
    {
        return [
            ['<track>', null],
            ['<track label="Hello">', 'Hello'],
        ];
    }

    #[DataProvider('dataLabel')]
    public function testLabel(string $expected, ?string $label): void
    {
        $this->assertSame($expected, (string) Track::tag()->label($label));
    }

    public function testSrc(): void
    {
        $this->assertSame(
            '<track src="brave.en.vtt">',
            (string) Track::tag()->src('brave.en.vtt')
        );
    }

    public static function dataSrclang(): array
    {
        return [
            ['<track>', null],
            ['<track srclang="ru">', 'ru'],
        ];
    }

    #[DataProvider('dataSrclang')]
    public function testSrclang(string $expected, ?string $lang): void
    {
        $this->assertSame($expected, (string) Track::tag()->srclang($lang));
    }

    public function testImmutability(): void
    {
        $track = Track::tag();
        $this->assertNotSame($track, $track->default());
        $this->assertNotSame($track, $track->kind(null));
        $this->assertNotSame($track, $track->label(null));
        $this->assertNotSame($track, $track->src('face.jpg'));
        $this->assertNotSame($track, $track->srclang(null));
    }
}
