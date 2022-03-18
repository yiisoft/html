<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Source;
use Yiisoft\Html\Tag\Track;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Objects\TestMediaTag;

final class MediaTagTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<test controls>' . "\n" .
            '<source src="a.mp3">' . "\n" .
            '<source src="b.ogg">' . "\n" .
            '<track src="c.mp3">' . "\n" .
            'Your browser does not support media.' . "\n" .
            '</test>',
            (string) TestMediaTag::tag()
                ->controls()
                ->sources(Source::tag()->src('a.mp3'), Source::tag()->src('b.ogg'))
                ->tracks(Track::tag()->src('c.mp3'))
                ->fallback('Your browser does not support media.')
        );
    }

    public function dataFallback(): array
    {
        return [
            ['<test></test>', null],
            ['<test></test>', ''],
            ["<test>\nhello\n</test>", 'hello'],
            ["<test>\nfallback\n</test>", new StringableObject('fallback')],
        ];
    }

    /**
     * @dataProvider dataFallback
     */
    public function testFallback($fallback): void
    {
        $tag = TestMediaTag::tag()->fallback($fallback);
        $this->assertSame('<test>' . "\n" . $fallback . "\n" . '</test>', (string) $tag);
    }

    public function testInvalidFallback(): void
    {
        $tag = TestMediaTag::tag();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Fallback content must be null, string or Stringable. "integer" given.');
        $tag->fallback(12);
    }

    public function testTracks(): void
    {
        $tag = TestMediaTag::tag()->tracks(
            Track::tag()->src('a.mp4'),
            Track::tag()->src('b.mp4')
        );

        $this->assertSame("<test>\n<track src=\"a.mp4\">\n<track src=\"b.mp4\">\n</test>", (string) $tag);
    }

    public function testAddTrack(): void
    {
        $tag = TestMediaTag::tag()
            ->tracks(Track::tag()->src('a.mp4'))
            ->addTrack(Track::tag()->src('b.mp4'))
            ->addTrack(Track::tag()->src('c.mp4'));

        $this->assertSame(
            "<test>\n<track src=\"a.mp4\">\n<track src=\"b.mp4\">\n<track src=\"c.mp4\">\n</test>",
            (string) $tag
        );
    }

    public function dataSrc(): array
    {
        return [
            ['<test></test>', null],
            ['<test src="hello.mp3"></test>', 'hello.mp3'],
        ];
    }

    /**
     * @dataProvider dataSrc
     */
    public function testSrc(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->src($url));
    }

    public function dataCrossOrigin(): array
    {
        return [
            ['<test></test>', null],
            ['<test crossorigin="anonymous"></test>', TestMediaTag::CROSSORIGIN_ANONYMOUS],
        ];
    }

    /**
     * @dataProvider dataCrossOrigin
     */
    public function testCrossOrigin(string $expected, ?string $crossOrigin): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->crossOrigin($crossOrigin));
    }

    public function dataPreload(): array
    {
        return [
            ['<test></test>', null],
            ['<test preload="none"></test>', TestMediaTag::PRELOAD_NONE],
        ];
    }

    /**
     * @dataProvider dataPreload
     */
    public function testPreload(string $expected, ?string $preload): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->preload($preload));
    }

    public function testMuted(): void
    {
        $this->assertSame('<test muted></test>', (string) TestMediaTag::tag()->muted());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->muted(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->muted(true)->muted(false));
    }

    public function testLoop(): void
    {
        $this->assertSame('<test loop></test>', (string) TestMediaTag::tag()->loop());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->loop(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->loop(true)->loop(false));
    }

    public function testAutoplay(): void
    {
        $this->assertSame('<test autoplay></test>', (string) TestMediaTag::tag()->autoplay());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->autoplay(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->autoplay(true)->autoplay(false));
    }

    public function testControls(): void
    {
        $this->assertSame('<test controls></test>', (string) TestMediaTag::tag()->controls());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->controls(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->controls(true)->controls(false));
    }
}
