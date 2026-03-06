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
            '<audio controls>' . "\n"
            . '<source src="a.mp3">' . "\n"
            . '<source src="b.ogg">' . "\n"
            . '<track src="c.mp3">' . "\n"
            . 'Your browser does not support audio.' . "\n"
            . '</audio>',
            (string) (new Audio())
                ->controls()
                ->sources(new Source()->src('a.mp3'), (new Source())->src('b.ogg'))
                ->tracks(new Track()->src('c.mp3'))
                ->fallback('Your browser does not support audio.'),
        );
    }
}
