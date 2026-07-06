<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Embed;

final class EmbedTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<embed>',
            (string) new Embed(),
        );
    }

    public function testSrc(): void
    {
        $this->assertSame(
            '<embed src="https://example.com/video.mp4">',
            (string) (new Embed())->src('https://example.com/video.mp4'),
        );
    }

    public function testType(): void
    {
        $this->assertSame(
            '<embed type="video/mp4">',
            (string) (new Embed())->type('video/mp4'),
        );
    }

    public function testWidth(): void
    {
        $this->assertSame(
            '<embed width="640">',
            (string) (new Embed())->width(640),
        );
    }

    public function testHeight(): void
    {
        $this->assertSame(
            '<embed height="480">',
            (string) (new Embed())->height(480),
        );
    }

    public function testImmutability(): void
    {
        $embed = new Embed();
        $this->assertNotSame($embed, $embed->src(null));
        $this->assertNotSame($embed, $embed->type(null));
        $this->assertNotSame($embed, $embed->width(null));
        $this->assertNotSame($embed, $embed->height(null));
    }
}
