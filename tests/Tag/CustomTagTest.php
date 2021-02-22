<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\CustomTag;

final class CustomTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="custom" count="15">body</test>',
            CustomTag::name('test')->id('custom')->attribute('count', 15)->content('body')->render()
        );
    }

    public function dataVoidTags(): array
    {
        return [
            ['area'],
            ['AREA'],
            ['br'],
            ['hr'],
        ];
    }

    /**
     * @dataProvider dataVoidTags
     *
     * @psalm-param non-empty-string $name
     */
    public function testVoidTags(string $name): void
    {
        self::assertSame(
            "<$name>",
            CustomTag::name($name)->render()
        );
    }

    public function dataNormal(): array
    {
        return [
            ['<h1></h1>', 'h1'],
            ['<col></col>', 'col'],
        ];
    }

    /**
     * @dataProvider dataNormal
     */
    public function testNormal(string $expected, string $name): void
    {
        $this->assertSame($expected, CustomTag::name($name)->normal()->render());
    }

    public function dataVoid(): array
    {
        return [
            ['<h1>', 'h1'],
            ['<col>', 'col'],
        ];
    }

    /**
     * @dataProvider dataVoid
     */
    public function testVoid(string $expected, string $name): void
    {
        $this->assertSame($expected, CustomTag::name($name)->void()->render());
    }

    public function testImmutability(): void
    {
        $tag = CustomTag::name('test');
        self::assertNotSame($tag, $tag->normal());
        self::assertNotSame($tag, $tag->void());
    }
}
