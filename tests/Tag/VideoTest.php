<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Video;
use Yiisoft\Html\Tag\Track;
use Yiisoft\Html\Tag\Source;

final class VideoTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<video controls>' . "\n"
            . '<source src="a.mp4">' . "\n"
            . '<source src="b.avi">' . "\n"
            . '<track src="c.mp4">' . "\n"
            . 'Your browser does not support video.' . "\n"
            . '</video>',
            (string) (new Video())
                ->controls()
                ->sources((new Source())->src('a.mp4'), (new Source())->src('b.avi'))
                ->tracks((new Track())->src('c.mp4'))
                ->fallback('Your browser does not support video.'),
        );
    }

    public static function dataPoster(): array
    {
        return [
            ['<video></video>', null],
            ['<video poster="face.jpg"></video>', 'face.jpg'],
        ];
    }

    #[DataProvider('dataPoster')]
    public function testPoster(string $expected, ?string $poster): void
    {
        $this->assertSame($expected, (string) (new Video())->poster($poster));
    }

    public static function dataWidth(): array
    {
        return [
            ['<video></video>', null],
            ['<video width="300"></video>', 300],
            ['<video width="50%"></video>', '50%'],
        ];
    }

    #[DataProvider('dataWidth')]
    public function testWidth(string $expected, $width): void
    {
        $this->assertSame($expected, (string) (new Video())->width($width));
    }

    public static function dataHeight(): array
    {
        return [
            ['<video></video>', null],
            ['<video height="300"></video>', 300],
            ['<video height="50%"></video>', '50%'],
        ];
    }

    #[DataProvider('dataHeight')]
    public function testHeight(string $expected, $height): void
    {
        $this->assertSame($expected, (string) (new Video())->height($height));
    }

    public function testImmutability(): void
    {
        $tag = new Video();
        $this->assertNotSame($tag, $tag->poster(null));
        $this->assertNotSame($tag, $tag->width(null));
        $this->assertNotSame($tag, $tag->height(null));
    }
}
