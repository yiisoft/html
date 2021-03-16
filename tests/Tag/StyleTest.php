<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Style;

final class StyleTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<style>.red { color: #f00; }</style>',
            (string)Style::tag()->content('.red { color: #f00; }')
        );
    }

    public function testContent(): void
    {
        $this->assertSame(
            '<style>body { display: block }</style>',
            Style::tag()->content('body { display: block }')->render()
        );
    }


    public function dataMedia(): array
    {
        return [
            ['<style></style>', null],
            ['<style media="all"></style>', 'all'],
        ];
    }

    /**
     * @dataProvider dataMedia
     */
    public function testMedia(string $expected, ?string $media): void
    {
        $this->assertSame($expected, (string)Style::tag()->media($media));
    }

    public function dataType(): array
    {
        return [
            ['<style></style>', null],
            ['<style type="text/css"></style>', 'text/css'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string)Style::tag()->type($type));
    }

    public function testImmutability(): void
    {
        $tag = Style::tag();
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->media(null));
        $this->assertNotSame($tag, $tag->type(null));
    }
}
