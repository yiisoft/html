<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Source;

final class SourceTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<source type="audio/ogg; codecs=vorbis" src="audio.ogg">',
            (string) Source::tag()->src('audio.ogg')->type('audio/ogg; codecs=vorbis')
        );
    }

    public function dataType(): array
    {
        return [
            ['<source>', null],
            ['<source type="audio/ogg; codecs=speex">', 'audio/ogg; codecs=speex'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) Source::tag()->type($url));
    }

    public function dataSrc(): array
    {
        return [
            ['<source>', null],
            ['<source src="video.mp4">', 'video.mp4'],
        ];
    }

    /**
     * @dataProvider dataSrc
     */
    public function testSrc(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) Source::tag()->src($url));
    }

    public function dataSrcset(): array
    {
        return [
            ['<source>', []],
            ['<source>', [null]],
            ['<source srcset="banner-HD.jpeg 2x">', ['banner-HD.jpeg 2x']],
            [
                '<source srcset="banner-phone.jpeg,banner-phone-HD.jpeg 2x">',
                ['banner-phone.jpeg', 'banner-phone-HD.jpeg 2x'],
            ],
        ];
    }

    /**
     * @dataProvider dataSrcset
     */
    public function testSrcset(string $expected, array $items): void
    {
        $this->assertSame($expected, (string) Source::tag()->srcset(...$items));
    }

    public function dataSizes(): array
    {
        return [
            ['<source>', []],
            ['<source>', [null]],
            ['<source sizes="(max-width: 700px) 100px">', ['(max-width: 700px) 100px']],
            [
                '<source sizes="(max-width: 700px) 100px,(max-width: 1000px) 200px">',
                ['(max-width: 700px) 100px', '(max-width: 1000px) 200px'],
            ],
        ];
    }

    /**
     * @dataProvider dataSizes
     */
    public function testSizes(string $expected, array $items): void
    {
        $this->assertSame($expected, (string) Source::tag()->sizes(...$items));
    }

    public function dataWidth(): array
    {
        return [
            ['<source>', null],
            ['<source width="300">', 300],
            ['<source width="50%">', '50%'],
        ];
    }

    /**
     * @dataProvider dataWidth
     */
    public function testWidth(string $expected, $width): void
    {
        $this->assertSame($expected, (string) Source::tag()->width($width));
    }

    public function dataHeight(): array
    {
        return [
            ['<source>', null],
            ['<source height="300">', 300],
            ['<source height="50%">', '50%'],
        ];
    }

    /**
     * @dataProvider dataHeight
     */
    public function testHeight(string $expected, $height): void
    {
        $this->assertSame($expected, (string) Source::tag()->height($height));
    }

    public function testImmutability(): void
    {
        $source = Source::tag();
        $this->assertNotSame($source, $source->type(null));
        $this->assertNotSame($source, $source->src(null));
        $this->assertNotSame($source, $source->srcset(null));
        $this->assertNotSame($source, $source->sizes(null));
        $this->assertNotSame($source, $source->media(null));
        $this->assertNotSame($source, $source->width(null));
        $this->assertNotSame($source, $source->height(null));
    }
}
