<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestTag;

final class TagTest extends TestCase
{
    public function dataAttributes(): array
    {
        return [
            ['<test>', []],
            ['<test>', ['id' => null]],
            ['<test id="main">', ['id' => 'main']],
            ['<test value="1&lt;&gt;">', ['value' => '1<>']],
            [
                '<test checked disabled required="yes">',
                ['checked' => true, 'disabled' => true, 'hidden' => false, 'required' => 'yes'],
            ],
            ['<test class>', ['class' => '']],
            ['<test class="red">', ['class' => 'red']],
            ['<test class="first second">', ['class' => ['first', 'second']]],
            ['<test>', ['class' => []]],
            ['<test style="width: 100px; height: 200px;">', ['style' => ['width' => '100px', 'height' => '200px']]],
            ['<test name="position" value="42">', ['value' => 42, 'name' => 'position']],
            [
                '<test id="x" class="a b" data-a="1" data-b="2" style="width: 100px;" any=\'[1,2]\'>',
                [
                    'id' => 'x',
                    'class' => ['a', 'b'],
                    'data' => ['a' => 1, 'b' => 2],
                    'style' => ['width' => '100px'],
                    'any' => [1, 2],
                ],
            ],
            [
                '<test data-a="0" data-b=\'[1,2]\' any="42">',
                [
                    'class' => [],
                    'style' => [],
                    'data' => ['a' => 0, 'b' => [1, 2]],
                    'any' => 42,
                ],
            ],
            [
                '<test data-foo=\'[]\'>',
                [
                    'data' => [
                        'foo' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataAttributes
     */
    public function testAttributes(string $expected, array $attributes): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->attributes($attributes));
        $this->assertSame($expected, (string)TestTag::tag()->replaceAttributes($attributes));
    }

    public function testAttributesMerge(): void
    {
        $this->assertSame(
            '<test id="color" class="green">',
            TestTag::tag()
                ->id('color')
                ->class('red')
                ->attributes(['class' => 'green'])
                ->render(),
        );
    }

    public function testReplaceAttributes(): void
    {
        $this->assertSame(
            '<test class="green">',
            TestTag::tag()
                ->id('color')
                ->class('red')
                ->replaceAttributes(['class' => 'green'])
                ->render(),
        );
    }

    public function testUnionAttributes(): void
    {
        $this->assertSame(
            '<test id="color" class="red">',
            TestTag::tag()
                ->class('red')
                ->unionAttributes(['class' => 'green', 'id' => 'color'])
                ->render(),
        );
    }

    public function dataAttribute(): array
    {
        return [
            ['<test>', null],
            ['<test key="one">', 'one'],
            ['<test key="42">', 42],
        ];
    }

    /**
     * @dataProvider dataAttribute
     */
    public function testAttribute(string $expected, $value): void
    {
        $this->assertSame($expected, TestTag::tag()
            ->attribute('key', $value)
            ->render());
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
            ['<test class="main">', []],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['bold']],
            ['<test class="main italic bold">', ['italic bold']],
            ['<test class="main italic bold">', ['italic', 'bold']],
        ];
    }

    /**
     * @dataProvider dataClass
     *
     * @param string[] $class
     */
    public function testClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()
            ->class('main')
            ->class(...$class));
    }

    public function dataNewClass(): array
    {
        return [
            ['<test>', null],
            ['<test class>', ''],
            ['<test class="red">', 'red'],
        ];
    }

    /**
     * @dataProvider dataNewClass
     */
    public function testNewClass(string $expected, ?string $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->class($class));
    }

    public function dataReplaceClass(): array
    {
        return [
            ['<test>', []],
            ['<test>', [null]],
            ['<test class>', ['']],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['main bold']],
            ['<test class="main bold">', ['main', 'bold']],
        ];
    }

    /**
     * @dataProvider dataReplaceClass
     *
     * @param string[] $class
     */
    public function testReplaceClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()
            ->class('red')
            ->replaceClass(...$class));
    }

    public function testImmutability(): void
    {
        $tag = TestTag::tag();
        $this->assertNotSame($tag, $tag->attributes([]));
        $this->assertNotSame($tag, $tag->replaceAttributes([]));
        $this->assertNotSame($tag, $tag->unionAttributes([]));
        $this->assertNotSame($tag, $tag->attribute('id', null));
        $this->assertNotSame($tag, $tag->id(null));
        $this->assertNotSame($tag, $tag->class('test'));
        $this->assertNotSame($tag, $tag->replaceClass('test'));
    }
}
