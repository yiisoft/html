<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Style;

final class StyleTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<style>.red { color: #f00; }</style>',
            (string) Style::tag()->content('.red { color: #f00; }'),
        );
    }

    public function testContent(): void
    {
        $content = 'body { display: block }';
        $tag = Style::tag()->content($content);

        $this->assertSame($content, $tag->getContent());
        $this->assertSame('<style>' . $content . '</style>', $tag->render());
    }

    public static function dataMedia(): array
    {
        return [
            ['<style></style>', null],
            ['<style media="all"></style>', 'all'],
        ];
    }

    #[DataProvider('dataMedia')]
    public function testMedia(string $expected, ?string $media): void
    {
        $this->assertSame($expected, (string) Style::tag()->media($media));
    }

    public static function dataType(): array
    {
        return [
            ['<style></style>', null],
            ['<style type="text/css"></style>', 'text/css'],
        ];
    }

    #[DataProvider('dataType')]
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string) Style::tag()->type($type));
    }

    public function testImmutability(): void
    {
        $tag = Style::tag();
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->media(null));
        $this->assertNotSame($tag, $tag->type(null));
    }
}
