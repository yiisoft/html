<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Script;

final class ScriptTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<script src="main.js"></script>',
            (string)Script::tag()->url('main.js')
        );
    }

    public function testContent(): void
    {
        $this->assertSame(
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
        $this->assertSame($expected, (string)Script::tag()->url($url));
        $this->assertSame($expected, (string)Script::tag()->src($url));
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
        $this->assertSame($expected, (string)Script::tag()->type($type));
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
        $this->assertSame($expected, (string)Script::tag()->charset($charset));
    }

    public function testAsync(): void
    {
        $this->assertSame('<script async></script>', (string)Script::tag()->async());
        $this->assertSame('<script></script>', (string)Script::tag()->async(false));
        $this->assertSame('<script></script>', (string)Script::tag()->async(true)->async(false));
    }

    public function testDefer(): void
    {
        $this->assertSame('<script defer></script>', (string)Script::tag()->defer());
        $this->assertSame('<script></script>', (string)Script::tag()->defer(false));
        $this->assertSame('<script></script>', (string)Script::tag()->defer(true)->defer(false));
    }

    public function testImmutability(): void
    {
        $script = Script::tag();
        $this->assertNotSame($script, $script->content(''));
        $this->assertNotSame($script, $script->url(null));
        $this->assertNotSame($script, $script->src(null));
        $this->assertNotSame($script, $script->type(null));
        $this->assertNotSame($script, $script->charset(null));
        $this->assertNotSame($script, $script->async());
        $this->assertNotSame($script, $script->defer());
    }
}
