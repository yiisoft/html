<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestTag;

final class TagTest extends TestCase
{
    public function dataAttributes(): array
    {
        return [
            ['<test>', []],
            ['<test id="main">', ['id' => 'main']],
        ];
    }

    /**
     * @dataProvider dataAttributes
     */
    public function testAttributes(string $expected, array $attributes): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->attributes($attributes));
    }

    public function dataId(): array
    {
        return [
            ['<test>', null],
            ['<test id="main">', 'main'],
        ];
    }

    /**
     * @dataProvider dataId
     */
    public function testId(string $expected, ?string $id): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->id($id));
    }

    public function dataClass(): array
    {
        return [
            ['<test>', []],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['main bold']],
            ['<test class="main bold">', ['main', 'bold']],
        ];
    }

    /**
     * @dataProvider dataClass
     *
     * @param string[] $class
     */
    public function testClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->class(...$class));
    }


    public function dataAddClass(): array
    {
        return [
            ['<test class="main">', []],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['bold']],
            ['<test class="main italic bold">', ['italic bold']],
            ['<test class="main italic bold">', ['italic', 'bold']],
        ];
    }

    /**
     * @dataProvider dataAddClass
     *
     * @param string[] $class
     */
    public function testAddClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->class('main')->addClass(...$class));
    }

    public function testImmutability(): void
    {
        $tag = TestTag::tag();
        $this->assertNotSame($tag, $tag->attributes([]));
        $this->assertNotSame($tag, $tag->id(null));
        $this->assertNotSame($tag, $tag->class('test'));
        $this->assertNotSame($tag, $tag->addClass('test'));
    }
}
