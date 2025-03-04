<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Img;

final class ImgTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<img src="logo.png" alt="Great Company">',
            (string)Img::tag()
                ->url('logo.png')
                ->alt('Great Company')
        );
    }

    public static function dataUrl(): array
    {
        return [
            ['<img>', null],
            ['<img src="logo.png">', 'logo.png'],
        ];
    }

    #[DataProvider('dataUrl')]
    public function testUrl(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string)Img::tag()->url($url));
        $this->assertSame($expected, (string)Img::tag()->src($url));
    }

    public static function dataSrcset(): array
    {
        return [
            ['<img>', [null]],
            ['<img>', []],
            ['<img srcset="logo.png 9001w">', ['logo.png 9001w']],
            ['<img srcset="/example-100w 100w,/example-500w 500w">', ['/example-100w 100w', '/example-500w 500w']],
        ];
    }

    #[DataProvider('dataSrcset')]
    public function testSrcset(string $expected, array $items): void
    {
        $this->assertSame($expected, (string)Img::tag()->srcset(...$items));
    }

    public static function dataSrcsetData(): array
    {
        return [
            ['<img>', []],
            ['<img srcset="/example-9001w 9001w">', ['9001w' => '/example-9001w']],
            [
                '<img srcset="/example-100w 100w,/example-500w 500w,/example-1500w 1500w">',
                [
                    '100w' => '/example-100w',
                    '500w' => '/example-500w',
                    '1500w' => '/example-1500w',
                ],
            ],
        ];
    }

    #[DataProvider('dataSrcsetData')]
    public function testSrcsetData(string $expected, array $items): void
    {
        $this->assertSame($expected, (string)Img::tag()->srcsetData($items));
    }

    public static function dataAlt(): array
    {
        return [
            ['<img>', null],
            ['<img alt="Logo">', 'Logo'],
        ];
    }

    #[DataProvider('dataAlt')]
    public function testAlt(string $expected, ?string $text): void
    {
        $this->assertSame($expected, (string)Img::tag()->alt($text));
    }

    public static function dataWidth(): array
    {
        return [
            ['<img>', null],
            ['<img width="300">', 300],
            ['<img width="50%">', '50%'],
        ];
    }

    #[DataProvider('dataWidth')]
    public function testWidth(string $expected, $width): void
    {
        $this->assertSame($expected, (string)Img::tag()->width($width));
    }

    public static function dataHeight(): array
    {
        return [
            ['<img>', null],
            ['<img height="300">', 300],
            ['<img height="50%">', '50%'],
        ];
    }

    #[DataProvider('dataHeight')]
    public function testHeight(string $expected, $height): void
    {
        $this->assertSame($expected, (string)Img::tag()->height($height));
    }

    public static function dataSize(): array
    {
        return [
            ['<img>', null, null],
            ['<img width="300" height="200">', 300, 200],
            ['<img width="50%" height="25%">', '50%', '25%'],
        ];
    }

    #[DataProvider('dataSize')]
    public function testSize(string $expected, $width, $height): void
    {
        $this->assertSame($expected, (string)Img::tag()->size($width, $height));
    }

    public static function dataLoading(): array
    {
        return [
            ['<img>', null],
            ['<img loading="eager">', 'eager'],
            ['<img loading="lazy">', 'lazy'],
        ];
    }

    #[DataProvider('dataLoading')]
    public function testLoading(string $expected, ?string $loading): void
    {
        $this->assertSame($expected, (string)Img::tag()->loading($loading));
    }

    public function testImmutability(): void
    {
        $img = Img::tag();
        $this->assertNotSame($img, $img->url(null));
        $this->assertNotSame($img, $img->src(null));
        $this->assertNotSame($img, $img->srcset());
        $this->assertNotSame($img, $img->srcsetData([]));
        $this->assertNotSame($img, $img->alt(null));
        $this->assertNotSame($img, $img->width(null));
        $this->assertNotSame($img, $img->height(null));
        $this->assertNotSame($img, $img->size(null, null));
        $this->assertNotSame($img, $img->loading(null));
    }
}
