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
            (string) (new TestMediaTag())
                ->controls()
                ->sources((new Source())->src('a.mp3'), (new Source())->src('b.ogg'))
                ->tracks((new Track())->src('c.mp3'))
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
        $tag = (new TestMediaTag())->fallback($fallback);
        $this->assertSame('<test>' . "\n" . $fallback . "\n" . '</test>', (string) $tag);
    }

    public function testTracks(): void
    {
        $tag = (new TestMediaTag())->tracks(
            (new Track())->src('a.mp4'),
            (new Track())->src('b.mp4'),
        );

        $this->assertSame("<test>\n<track src=\"a.mp4\">\n<track src=\"b.mp4\">\n</test>", (string) $tag);
    }

    public function testAddTrack(): void
    {
        $tag = (new TestMediaTag())
            ->tracks((new Track())->src('a.mp4'))
            ->addTrack((new Track())->src('b.mp4'))
            ->addTrack((new Track())->src('c.mp4'));

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
        $this->assertSame($expected, (string) (new TestMediaTag())->src($url));
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
        $this->assertSame($expected, (string) (new TestMediaTag())->crossOrigin($crossOrigin));
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
        $this->assertSame($expected, (string) (new TestMediaTag())->preload($preload));
    }

    public function testMuted(): void
    {
        $this->assertSame('<test muted></test>', (string) (new TestMediaTag())->muted());
        $this->assertSame('<test></test>', (string) (new TestMediaTag())->muted(false));
        $this->assertSame('<test></test>', (string) (new TestMediaTag())
            ->muted(true)
            ->muted(false));
    }

    public function testLoop(): void
    {
        $this->assertSame('<test loop></test>', (string) (new TestMediaTag())->loop());
        $this->assertSame('<test></test>', (string) (new TestMediaTag())->loop(false));
        $this->assertSame('<test></test>', (string) (new TestMediaTag())
            ->loop(true)
            ->loop(false));
    }

    public function testAutoplay(): void
    {
        $this->assertSame('<test autoplay></test>', (string) (new TestMediaTag())->autoplay());
        $this->assertSame('<test></test>', (string) (new TestMediaTag())->autoplay(false));
        $this->assertSame('<test></test>', (string) (new TestMediaTag())
            ->autoplay(true)
            ->autoplay(false));
    }

    public function testControls(): void
    {
        $this->assertSame('<test controls></test>', (string) (new TestMediaTag())->controls());
        $this->assertSame('<test></test>', (string) (new TestMediaTag())->controls(false));
        $this->assertSame('<test></test>', (string) (new TestMediaTag())
            ->controls(true)
            ->controls(false));
    }

    public function testWrongTrackDefault(): void
    {
        $tag = (new TestMediaTag())->tracks(
            (new Track())
                ->kind('captions')
                ->src('sampleCaptions.vtt')
                ->srclang('en')
                ->default(),
            (new Track())
                ->kind('descriptions')
                ->src('sampleDescriptions.vtt')
                ->srclang('de'),
            (new Track())
                ->kind('chapters')
                ->src('sampleChapters.vtt')
                ->srclang('ja')
                ->default(),
        );

        $this->assertSame(
            '<test>' . "\n"
            . '<track src="sampleCaptions.vtt" kind="captions" srclang="en" default>' . "\n"
            . '<track src="sampleDescriptions.vtt" kind="descriptions" srclang="de">' . "\n"
            . '<track src="sampleChapters.vtt" kind="chapters" srclang="ja">' . "\n"
            . '</test>',
            $tag->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = new TestMediaTag();
        $this->assertNotSame($tag, $tag->fallback(null));
        $this->assertNotSame($tag, $tag->tracks());
        $this->assertNotSame($tag, $tag->addTrack(new Track()));
        $this->assertNotSame($tag, $tag->src(null));
        $this->assertNotSame($tag, $tag->crossOrigin(null));
        $this->assertNotSame($tag, $tag->preload(null));
        $this->assertNotSame($tag, $tag->muted());
        $this->assertNotSame($tag, $tag->loop());
        $this->assertNotSame($tag, $tag->autoplay());
        $this->assertNotSame($tag, $tag->controls());
    }
}
