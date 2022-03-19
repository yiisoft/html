<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Audio;
use Yiisoft\Html\Tag\Source;
use Yiisoft\Html\Tag\Track;

final class AudioTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<audio controls>' . "\n" .
            '<source src="a.mp3">' . "\n" .
            '<source src="b.ogg">' . "\n" .
            '<track src="c.mp3">' . "\n" .
            'Your browser does not support audio.' . "\n" .
            '</audio>',
            (string) Audio::tag()
                ->controls()
                ->sources(Source::tag()->src('a.mp3'), Source::tag()->src('b.ogg'))
                ->tracks(Track::tag()->src('c.mp3'))
                ->fallback('Your browser does not support audio.')
        );
    }
}
