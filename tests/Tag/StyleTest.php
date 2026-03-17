<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Style;
use Yiisoft\Html\Tests\Objects\StringableObject;

final class StyleTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<style>.red { color: #f00; }</style>',
            (string) (new Style())->content('.red { color: #f00; }'),
        );
    }

    public function testContent(): void
    {
        $content = 'body { display: block }';
        $tag = (new Style())->content($content);

        $this->assertSame($content, $tag->getContent());
        $this->assertSame('<style>' . $content . '</style>', $tag->render());
    }

    public function testContentWithStringable(): void
    {
        $content = new StringableObject('body { color: red }');
        $tag = (new Style())->content($content);

        $this->assertSame('body { color: red }', $tag->getContent());
        $this->assertSame('<style>body { color: red }</style>', $tag->render());
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
        $this->assertSame($expected, (string) (new Style())->media($media));
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
        $this->assertSame($expected, (string) (new Style())->type($type));
    }

    public function testImmutability(): void
    {
        $tag = new Style();
        $this->assertNotSame($tag, $tag->content(''));
        $this->assertNotSame($tag, $tag->media(null));
        $this->assertNotSame($tag, $tag->type(null));
    }
}
