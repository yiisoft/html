<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Video;
use Yiisoft\Html\Tag\Track;
use Yiisoft\Html\Tag\Source;

final class VideoTest extends TestCase
{
    public function testSimpleVideo(): void
    {
        $video = Video::tag()->src('sample.mp4')->render();
        $expected = '<video src="sample.mp4"></video>';

        $this->assertSame($expected, $video);
    }

    public function testVideoAttributes(): void
    {
        $video = Video::tag()
            ->src('sample.mp4')
            ->width('640')
            ->height(480)
            ->poster('poster.jpg')
            ->autoplay(false)
            ->controls(true)
            ->render();
        $expected = '<video src="sample.mp4" width="640" height="480" poster="poster.jpg" controls></video>';

        $this->assertSame($expected, $video);
    }

    public function testVideoSources(): void
    {
        $video = Video::tag()
            ->width('640')
            ->height(480)
            ->poster('poster.jpg')
            ->autoplay(false)
            ->controls(true)
            ->loop(true)
            ->fallback("I'm sorry; your browser doesn't support HTML5 video.")
            ->sources(
                Source::tag()->src('foo.webm')->type('video/webm'),
                Source::tag()->src('foo.ogg')->type('video/ogg'),
                Source::tag()->src('foo.mov')->type('video/quicktime')
            )->render();
        $html = trim(str_replace('>', ">\n", $video));
        $expected = <<<'HTML'
        <video width="640" height="480" poster="poster.jpg" controls loop>
        <source type="video/webm" src="foo.webm">
        <source type="video/ogg" src="foo.ogg">
        <source type="video/quicktime" src="foo.mov">
        I'm sorry; your browser doesn't support HTML5 video.</video>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testVideoTracks(): void
    {
        $video = Video::tag()
            ->width('640')
            ->height(480)
            ->poster('poster.jpg')
            ->autoplay(false)
            ->controls(true)
            ->loop(true)
            ->fallback("I'm sorry; your browser doesn't support HTML5 video.")
            ->sources(
                Source::tag()->src('foo.webm')->type('video/webm'),
                Source::tag()->src('foo.ogg')->type('video/ogg'),
                Source::tag()->src('foo.mov')->type('video/quicktime')
            )->tracks(
                Track::tag()->kind('captions')->src('sampleCaptions.vtt')->srclang('en'),
                Track::tag()->kind('descriptions')->src('sampleDescriptions.vtt')->srclang('de'),
                Track::tag()->kind('chapters')->src('sampleChapters.vtt')->srclang('ja')->default()
            )->render();
        $html = trim(str_replace('>', ">\n", $video));
        $expected = <<<'HTML'
        <video width="640" height="480" poster="poster.jpg" controls loop>
        <source type="video/webm" src="foo.webm">
        <source type="video/ogg" src="foo.ogg">
        <source type="video/quicktime" src="foo.mov">
        <track src="sampleCaptions.vtt" kind="captions" srclang="en">
        <track src="sampleDescriptions.vtt" kind="descriptions" srclang="de">
        <track src="sampleChapters.vtt" kind="chapters" srclang="ja" default>
        I'm sorry; your browser doesn't support HTML5 video.</video>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testWrongTrackDefault(): void
    {
        $video = Video::tag()
            ->width('640')
            ->height(480)
            ->poster('poster.jpg')
            ->autoplay(false)
            ->controls(true)
            ->loop(true)
            ->fallback("I'm sorry; your browser doesn't support HTML5 video.")
            ->sources(
                Source::tag()->src('foo.webm')->type('video/webm'),
                Source::tag()->src('foo.ogg')->type('video/ogg'),
                Source::tag()->src('foo.mov')->type('video/quicktime')
            )->tracks(
                Track::tag()->kind('captions')->src('sampleCaptions.vtt')->srclang('en')->default(),
                Track::tag()->kind('descriptions')->src('sampleDescriptions.vtt')->srclang('de'),
                Track::tag()->kind('chapters')->src('sampleChapters.vtt')->srclang('ja')->default()
            )->render();
        $html = trim(str_replace('>', ">\n", $video));
        $expected = <<<'HTML'
        <video width="640" height="480" poster="poster.jpg" controls loop>
        <source type="video/webm" src="foo.webm">
        <source type="video/ogg" src="foo.ogg">
        <source type="video/quicktime" src="foo.mov">
        <track src="sampleCaptions.vtt" kind="captions" srclang="en" default>
        <track src="sampleDescriptions.vtt" kind="descriptions" srclang="de">
        <track src="sampleChapters.vtt" kind="chapters" srclang="ja">
        I'm sorry; your browser doesn't support HTML5 video.</video>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testSrcWithSource(): void
    {
        $video = Video::tag()
            ->src('video.mp4')
            ->width(640)
            ->height('480')
            ->poster('poster.jpg')
            ->autoplay(false)
            ->controls(true)
            ->loop(true)
            ->fallback("I'm sorry; your browser doesn't support HTML5 video.")
            ->sources(
                Source::tag()->src('foo.webm')->type('video/webm'),
                Source::tag()->src('foo.ogg')->type('video/ogg'),
                Source::tag()->src('foo.mov')->type('video/quicktime')
            )->render();
        $html = trim(str_replace('>', ">\n", $video));
        $expected = <<<'HTML'
        <video src="video.mp4" width="640" height="480" poster="poster.jpg" controls loop>
        I'm sorry; your browser doesn't support HTML5 video.</video>
        HTML;

        $this->assertSame($expected, $html);
    }
}
