<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Media;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Media\Audio;
use Yiisoft\Html\Tag\Source;
use Yiisoft\Html\Tag\Media\Track;

final class AudioTest extends TestCase
{
    public function testSimpleAudio(): void
    {
        $audio = Audio::tag()->src('sample.mp3')->render();
        $expected = '<audio src="sample.mp3"></audio>';

        $this->assertSame($expected, $audio);
    }

    public function testAudioAttributes(): void
    {
        $audio = Audio::tag()
            ->src('sample.mp3')
            ->autoplay()
            ->loop()
            ->muted()
            ->controls()
            ->render();
        $expected = '<audio src="sample.mp3" autoplay loop muted controls></audio>';

        $this->assertSame($expected, $audio);
    }

    public function testAudioFallback(): void
    {
        $audio = Audio::tag()
            ->src('sample.mp3')
            ->autoplay(false)
            ->loop(false)
            ->muted(false)
            ->controls()
            ->fallback('Your browser does not support the audio element.')
            ->render();
        $expected = '<audio src="sample.mp3" controls>Your browser does not support the audio element.</audio>';

        $this->assertSame($expected, $audio);
    }

    public function testAudioSources(): void
    {
        $audio = Audio::tag()
            ->autoplay(false)
            ->loop(false)
            ->muted(false)
            ->controls()
            ->fallback('<p>Your browser does not support the audio element.</p>')
            ->sources(
                Source::tag()->src('myAudio.mp3')->type('audio/mpeg'),
                Source::tag()->src('myAudio.ogg')->type('audio/ogg')
            )->render();
        $html = trim(str_replace('>', ">\n", $audio));
        $expected = <<<'HTML'
        <audio controls>
        <source type="audio/mpeg" src="myAudio.mp3">
        <source type="audio/ogg" src="myAudio.ogg">
        <p>
        Your browser does not support the audio element.</p>
        </audio>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testAudioTracks(): void
    {
        $audio = Audio::tag()
            ->autoplay(false)
            ->loop(false)
            ->muted(false)
            ->controls()
            ->fallback('Your browser does not support the audio element.')
            ->sources(
                Source::tag()->src('myAudio.mp3')->type('audio/mpeg'),
                Source::tag()->src('myAudio.ogg')->type('audio/ogg')
            )->tracks(
                Track::tag()->default()->kind('caption')->srclang('en')->src('friday.vtt')
            )->render();
        $html = trim(str_replace('>', ">\n", $audio));
        $expected = <<<'HTML'
        <audio controls>
        <source type="audio/mpeg" src="myAudio.mp3">
        <source type="audio/ogg" src="myAudio.ogg">
        <track src="friday.vtt" default kind="caption" srclang="en">
        Your browser does not support the audio element.</audio>
        HTML;

        $this->assertSame($expected, $html);
    }
}
