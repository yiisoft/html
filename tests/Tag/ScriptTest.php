<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Noscript;
use Yiisoft\Html\Tag\Script;

final class ScriptTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<script src="main.js"></script>',
            (string) (new Script())->url('main.js'),
        );
    }

    public function testContent(): void
    {
        $content = 'alert("4 > 2");';
        $tag = (new Script())->content($content);

        $this->assertSame($content, $tag->getContent());
        $this->assertSame('<script>' . $content . '</script>', $tag->render());
    }

    public static function dataUrl(): array
    {
        return [
            ['<script></script>', null],
            ['<script src="main.js"></script>', 'main.js'],
        ];
    }

    #[DataProvider('dataUrl')]
    public function testUrl(string $expected, ?string $url): void
    {
        $this->assertSame($expected, (string) (new Script())->url($url));
        $this->assertSame($expected, (string) (new Script())->src($url));
    }

    public static function dataType(): array
    {
        return [
            ['<script></script>', null],
            ['<script type="text/javascript"></script>', 'text/javascript'],
        ];
    }

    #[DataProvider('dataType')]
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string) (new Script())->type($type));
    }

    public static function dataCharset(): array
    {
        return [
            ['<script></script>', null],
            ['<script charset="UTF-8"></script>', 'UTF-8'],
        ];
    }

    #[DataProvider('dataCharset')]
    public function testCharset(string $expected, ?string $charset): void
    {
        $this->assertSame($expected, (string) (new Script())->charset($charset));
    }

    public function testAsync(): void
    {
        $this->assertSame('<script async></script>', (string) (new Script())->async());
        $this->assertSame('<script></script>', (string) (new Script())->async(false));
        $this->assertSame('<script></script>', (string) (new Script())
            ->async(true)
            ->async(false));
    }

    public function testDefer(): void
    {
        $this->assertSame('<script defer></script>', (string) (new Script())->defer());
        $this->assertSame('<script></script>', (string) (new Script())->defer(false));
        $this->assertSame('<script></script>', (string) (new Script())
            ->defer(true)
            ->defer(false));
    }

    public function testNoscript(): void
    {
        $this->assertSame(
            '<script></script><noscript>hello</noscript>',
            (string) (new Script())->noscript('hello'),
        );
        $this->assertSame(
            '<script></script><noscript><div></div></noscript>',
            (string) (new Script())->noscript(new Div()),
        );
        $this->assertSame(
            '<script></script>',
            (string) (new Script())->noscript(null),
        );
    }

    public function testNoscriptTag(): void
    {
        $noscriptTag = (new Noscript())->content('hello');
        $this->assertSame(
            '<script></script><noscript>hello</noscript>',
            (string) (new Script())->noscriptTag($noscriptTag),
        );
        $this->assertSame(
            '<script></script>',
            (string) (new Script())->noscriptTag(null),
        );
    }

    public function testImmutability(): void
    {
        $script = new Script();
        $this->assertNotSame($script, $script->content(''));
        $this->assertNotSame($script, $script->url(null));
        $this->assertNotSame($script, $script->src(null));
        $this->assertNotSame($script, $script->type(null));
        $this->assertNotSame($script, $script->charset(null));
        $this->assertNotSame($script, $script->async());
        $this->assertNotSame($script, $script->defer());
        $this->assertNotSame($script, $script->noscript(null));
        $this->assertNotSame($script, $script->noscriptTag(null));
        $this->assertNotSame($script, $script->nonce(null));
    }

    public static function dataNonce(): iterable
    {
        yield ['<script nonce="test-nonce"></script>', 'test-nonce'];
        yield ['<script></script>', null];
        yield ['<script nonce></script>', ''];
        yield ['<script nonce="0"></script>', '0'];
    }

    #[DataProvider('dataNonce')]
    public function testNonce(string $expectedHtml, ?string $nonce): void
    {
        $script = (new Script())->nonce($nonce);

        $this->assertSame($expectedHtml, (string) $script);
        $this->assertSame($nonce, $script->getNonce());
    }

    public function testNonceWithoutValue(): void
    {
        $script = new Script();

        $this->assertSame('<script></script>', (string) $script);
        $this->assertNull($script->getNonce());
    }

    public function testInvalidNonce(): void
    {
        $script = (new Script())->attribute('nonce', []);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Nonce should be string or null. Got array.');
        $script->getNonce();
    }
}
