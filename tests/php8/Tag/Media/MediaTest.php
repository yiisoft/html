<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Php8\Tag\Media;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Media\Audio;

final class MediaTest extends TestCase
{
    public function testStringableFallback(): void
    {
        $audio = Audio::tag()
            ->autoplay(false)
            ->loop(false)
            ->muted(false)
            ->controls()
            ->fallback(Html::p('Your browser does not support the audio element.'))
            ->render();
        $html = trim(str_replace('>', ">\n", $audio));
        $expected = <<<'HTML'
        <audio controls>
        <p>
        Your browser does not support the audio element.</p>
        </audio>
        HTML;

        $this->assertSame($expected, $html);
    }
}
