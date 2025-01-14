<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestTag;
use Yiisoft\Html\Tests\Support\ClassEnum;
use Yiisoft\Html\Tests\Support\IntegerEnum;

final class TagTest extends TestCase
{
    public static function dataAttributes(): array
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
            ['<test value="42" name="position">', ['value' => 42, 'name' => 'position']],
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

    #[DataProvider('dataAttributes')]
    public function testAttributes(string $expected, array $attributes): void
    {
        $this->assertSame($expected, (string) TestTag::tag()->addAttributes($attributes));
        $this->assertSame($expected, (string) TestTag::tag()->attributes($attributes));
    }

    public function testAttributesMerge(): void
    {
        $this->assertSame(
            '<test id="color" class="green">',
            TestTag::tag()
                ->id('color')
                ->class('red')
                ->addAttributes(['class' => 'green'])
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
                ->attributes(['class' => 'green'])
                ->render(),
        );
    }

    public function testUnionAttributes(): void
    {
        $this->assertSame(
            '<test class="red" id="color">',
            TestTag::tag()
                ->class('red')
                ->unionAttributes(['class' => 'green', 'id' => 'color'])
                ->render(),
        );
    }

    public static function dataAttribute(): array
    {
        return [
            ['<test>', null],
            ['<test key="one">', 'one'],
            ['<test key="42">', 42],
        ];
    }

    #[DataProvider('dataAttribute')]
    public function testAttribute(string $expected, $value): void
    {
        $this->assertSame($expected, TestTag::tag()
            ->attribute('key', $value)
            ->render());
    }

    public static function dataId(): array
    {
        return [
            ['<test>', null],
            ['<test id="main">', 'main'],
        ];
    }

    #[DataProvider('dataId')]
    public function testId(string $expected, ?string $id): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->id($id));
    }

    public static function dataAddClass(): array
    {
        return [
            ['<test class="main">', []],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['bold']],
            ['<test class="main italic bold">', ['italic bold']],
            ['<test class="main italic bold">', ['italic', 'bold']],
            ['<test class="main test-class-1 test-class-2">', [ClassEnum::TEST_CLASS_1, ClassEnum::TEST_CLASS_2]],
            [
                '<test class="main test-class-1 test-class-2">',
                [IntegerEnum::A, ClassEnum::TEST_CLASS_1, IntegerEnum::B, ClassEnum::TEST_CLASS_2],
            ],
        ];
    }

    #[DataProvider('dataAddClass')]
    public function testAddClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()
            ->addClass('main')
            ->addClass(...$class));
    }

    public static function dataNewClass(): array
    {
        return [
            ['<test>', null],
            ['<test class>', ''],
            ['<test class="red">', 'red'],
        ];
    }

    #[DataProvider('dataNewClass')]
    public function testNewClass(string $expected, ?string $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()->addClass($class));
    }

    public static function dataClass(): array
    {
        return [
            ['<test>', []],
            ['<test>', [null]],
            ['<test class>', ['']],
            ['<test class="main">', ['main']],
            ['<test class="main bold">', ['main bold']],
            ['<test class="main bold">', ['main', 'bold']],
            ['<test class="test-class-1 test-class-2">', [ClassEnum::TEST_CLASS_1, ClassEnum::TEST_CLASS_2]],
            [
                '<test class="test-class-1 test-class-2">',
                [IntegerEnum::A, ClassEnum::TEST_CLASS_1, IntegerEnum::B, ClassEnum::TEST_CLASS_2],
            ],
        ];
    }

    #[DataProvider('dataClass')]
    public function testClass(string $expected, array $class): void
    {
        $this->assertSame($expected, (string)TestTag::tag()
            ->class('red')
            ->class(...$class));
    }

    public function testImmutability(): void
    {
        $tag = TestTag::tag();
        $this->assertNotSame($tag, $tag->addAttributes([]));
        $this->assertNotSame($tag, $tag->attributes([]));
        $this->assertNotSame($tag, $tag->unionAttributes([]));
        $this->assertNotSame($tag, $tag->attribute('id', null));
        $this->assertNotSame($tag, $tag->id(null));
        $this->assertNotSame($tag, $tag->addClass('test'));
        $this->assertNotSame($tag, $tag->class('test'));
    }
}
