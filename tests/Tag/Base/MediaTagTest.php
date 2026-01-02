<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
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
            '<test controls>' . "\n"
            . '<source src="a.mp3">' . "\n"
            . '<source src="b.ogg">' . "\n"
            . '<track src="c.mp3">' . "\n"
            . 'Your browser does not support media.' . "\n"
            . '</test>',
            (string) TestMediaTag::tag()
                ->controls()
                ->sources(Source::tag()->src('a.mp3'), Source::tag()->src('b.ogg'))
                ->tracks(Track::tag()->src('c.mp3'))
                ->fallback('Your browser does not support media.'),
        );
    }

    public static function dataFallback(): array
    {
        return [
            ['<test></test>', null],
            ['<test></test>', ''],
            ["<test>\nhello\n</test>", 'hello'],
            ["<test>\nfallback\n</test>", new StringableObject('fallback')],
        ];
    }

    #[DataProvider('dataFallback')]
    public function testFallback($fallback): void
    {
        $tag = TestMediaTag::tag()->fallback($fallback);
        $this->assertSame('<test>' . "\n" . $fallback . "\n" . '</test>', (string) $tag);
    }

    public function testTracks(): void
    {
        $tag = TestMediaTag::tag()->tracks(
            Track::tag()->src('a.mp4'),
            Track::tag()->src('b.mp4'),
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
            (string) $tag,
        );
    }

    public static function dataSrc(): array
    {
        return [
            ['<test></test>', null],
            ['<test src="hello.mp3"></test>', 'hello.mp3'],
        ];
    }

    #[DataProvider('dataSrc')]
    public function testSrc(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->src($url));
    }

    public static function dataCrossOrigin(): array
    {
        return [
            ['<test></test>', null],
            ['<test crossorigin="anonymous"></test>', TestMediaTag::CROSSORIGIN_ANONYMOUS],
        ];
    }

    #[DataProvider('dataCrossOrigin')]
    public function testCrossOrigin(string $expected, ?string $crossOrigin): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->crossOrigin($crossOrigin));
    }

    public static function dataPreload(): array
    {
        return [
            ['<test></test>', null],
            ['<test preload="none"></test>', TestMediaTag::PRELOAD_NONE],
        ];
    }

    #[DataProvider('dataPreload')]
    public function testPreload(string $expected, ?string $preload): void
    {
        $this->assertSame($expected, (string) TestMediaTag::tag()->preload($preload));
    }

    public function testMuted(): void
    {
        $this->assertSame('<test muted></test>', (string) TestMediaTag::tag()->muted());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->muted(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()
            ->muted(true)
            ->muted(false));
    }

    public function testLoop(): void
    {
        $this->assertSame('<test loop></test>', (string) TestMediaTag::tag()->loop());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->loop(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()
            ->loop(true)
            ->loop(false));
    }

    public function testAutoplay(): void
    {
        $this->assertSame('<test autoplay></test>', (string) TestMediaTag::tag()->autoplay());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->autoplay(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()
            ->autoplay(true)
            ->autoplay(false));
    }

    public function testControls(): void
    {
        $this->assertSame('<test controls></test>', (string) TestMediaTag::tag()->controls());
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()->controls(false));
        $this->assertSame('<test></test>', (string) TestMediaTag::tag()
            ->controls(true)
            ->controls(false));
    }

    public function testWrongTrackDefault(): void
    {
        $tag = TestMediaTag::tag()->tracks(
            Track::tag()
                ->kind('captions')
                ->src('sampleCaptions.vtt')
                ->srclang('en')
                ->default(),
            Track::tag()
                ->kind('descriptions')
                ->src('sampleDescriptions.vtt')
                ->srclang('de'),
            Track::tag()
                ->kind('chapters')
                ->src('sampleChapters.vtt')
                ->srclang('ja')
                ->default(),
        );

        $this->assertSame(
            '<test>' . "\n"
            . '<track kind="captions" src="sampleCaptions.vtt" srclang="en" default>' . "\n"
            . '<track kind="descriptions" src="sampleDescriptions.vtt" srclang="de">' . "\n"
            . '<track kind="chapters" src="sampleChapters.vtt" srclang="ja">' . "\n"
            . '</test>',
            $tag->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = TestMediaTag::tag();
        $this->assertNotSame($tag, $tag->fallback(null));
        $this->assertNotSame($tag, $tag->tracks());
        $this->assertNotSame($tag, $tag->addTrack(Track::tag()));
        $this->assertNotSame($tag, $tag->src(null));
        $this->assertNotSame($tag, $tag->crossOrigin(null));
        $this->assertNotSame($tag, $tag->preload(null));
        $this->assertNotSame($tag, $tag->muted());
        $this->assertNotSame($tag, $tag->loop());
        $this->assertNotSame($tag, $tag->autoplay());
        $this->assertNotSame($tag, $tag->controls());
    }
}
