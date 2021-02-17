<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Meta;

final class MetaTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<meta name="description" content="Yii Framework">',
            Meta::tag()
                ->name('description')
                ->content('Yii Framework')
                ->render()
        );
    }

    public function testDescription(): void
    {
        self::assertSame(
            '<meta name="description" content="Yii Framework">',
            Meta::description('Yii Framework')->render()
        );
    }

    public function dataName(): array
    {
        return [
            ['<meta>', null],
            ['<meta name="">', ''],
            ['<meta name="keywords">', 'keywords'],
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expected, ?string $name): void
    {
        self::assertSame($expected, (string)Meta::tag()->name($name));
    }

    public function dataContent(): array
    {
        return [
            ['<meta>', null],
            ['<meta content="">', ''],
            ['<meta content="Yii">', 'Yii'],
        ];
    }

    /**
     * @dataProvider dataContent
     */
    public function testContent(string $expected, ?string $content): void
    {
        self::assertSame($expected, (string)Meta::tag()->content($content));
    }

    public function testImmutability(): void
    {
        $tag = Meta::tag();
        self::assertNotSame($tag, $tag->name(null));
        self::assertNotSame($tag, $tag->content(null));
    }
}
