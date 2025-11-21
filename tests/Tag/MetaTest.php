<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Meta;

final class MetaTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<meta name="description" content="Yii Framework">',
            Meta::tag()
                ->name('description')
                ->content('Yii Framework')
                ->render(),
        );
    }

    public function testData(): void
    {
        $this->assertSame(
            '<meta name="keywords" content="yii">',
            Meta::data('keywords', 'yii')->render(),
        );
    }

    public function testPragmaDirective(): void
    {
        $this->assertSame(
            '<meta http-equiv="Cache-Control" content="public">',
            Meta::pragmaDirective('Cache-Control', 'public')->render(),
        );
    }

    public function testDocumentEncoding(): void
    {
        $this->assertSame(
            '<meta charset="utf-8">',
            Meta::documentEncoding('utf-8')->render(),
        );
    }

    public function testDescription(): void
    {
        $this->assertSame(
            '<meta name="description" content="Yii Framework">',
            Meta::description('Yii Framework')->render(),
        );
    }

    public static function dataProviderName(): array
    {
        return [
            ['<meta>', null],
            ['<meta name>', ''],
            ['<meta name="keywords">', 'keywords'],
        ];
    }

    #[DataProvider('dataProviderName')]
    public function testName(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) Meta::tag()->name($name));
    }

    public static function dataHttpEquiv(): array
    {
        return [
            ['<meta>', null],
            ['<meta http-equiv>', ''],
            ['<meta http-equiv="refresh">', 'refresh'],
        ];
    }

    #[DataProvider('dataHttpEquiv')]
    public function testHttpEquiv(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) Meta::tag()->httpEquiv($name));
    }

    public static function dataContent(): array
    {
        return [
            ['<meta>', null],
            ['<meta content>', ''],
            ['<meta content="Yii">', 'Yii'],
        ];
    }

    #[DataProvider('dataContent')]
    public function testContent(string $expected, ?string $content): void
    {
        $this->assertSame($expected, (string) Meta::tag()->content($content));
    }

    public static function dataCharset(): array
    {
        return [
            ['<meta>', null],
            ['<meta charset>', ''],
            ['<meta charset="utf-8">', 'utf-8'],
        ];
    }

    #[DataProvider('dataCharset')]
    public function testCharset(string $expected, ?string $charset): void
    {
        $this->assertSame($expected, (string) Meta::tag()->charset($charset));
    }

    public function testImmutability(): void
    {
        $tag = Meta::tag();
        $this->assertNotSame($tag, $tag->name(null));
        $this->assertNotSame($tag, $tag->httpEquiv(null));
        $this->assertNotSame($tag, $tag->content(null));
        $this->assertNotSame($tag, $tag->charset(null));
    }
}
