<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Script;

final class ScriptTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<script src="main.js"></script>',
            (string)Script::tag()->url('main.js')
        );
    }

    public function testContent(): void
    {
        self::assertSame(
            '<script>alert("4 > 2");</script>',
            Script::tag()->content('alert("4 > 2");')->render()
        );
    }

    public function dataUrl(): array
    {
        return [
            ['<script></script>', null],
            ['<script src="main.js"></script>', 'main.js'],
        ];
    }

    /**
     * @dataProvider dataUrl
     */
    public function testUrl(string $expected, ?string $url): void
    {
        self::assertSame($expected, (string)Script::tag()->url($url));
        self::assertSame($expected, (string)Script::tag()->src($url));
    }

    public function dataType(): array
    {
        return [
            ['<script></script>', null],
            ['<script type="text/javascript"></script>', 'text/javascript'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $type): void
    {
        self::assertSame($expected, (string)Script::tag()->type($type));
    }

    public function dataCharset(): array
    {
        return [
            ['<script></script>', null],
            ['<script charset="UTF-8"></script>', 'UTF-8'],
        ];
    }

    /**
     * @dataProvider dataCharset
     */
    public function testCharset(string $expected, ?string $charset): void
    {
        self::assertSame($expected, (string)Script::tag()->charset($charset));
    }

    public function testAsync(): void
    {
        self::assertSame('<script async></script>', (string)Script::tag()->async());
        self::assertSame('<script></script>', (string)Script::tag()->async(false));
        self::assertSame('<script></script>', (string)Script::tag()->async(true)->async(false));
    }

    public function testDefer(): void
    {
        self::assertSame('<script defer></script>', (string)Script::tag()->defer());
        self::assertSame('<script></script>', (string)Script::tag()->defer(false));
        self::assertSame('<script></script>', (string)Script::tag()->defer(true)->defer(false));
    }

    public function testImmutability(): void
    {
        $script = Script::tag();
        self::assertNotSame($script, $script->content(''));
        self::assertNotSame($script, $script->url(null));
        self::assertNotSame($script, $script->src(null));
        self::assertNotSame($script, $script->type(null));
        self::assertNotSame($script, $script->charset(null));
        self::assertNotSame($script, $script->async());
        self::assertNotSame($script, $script->defer());
    }
}
