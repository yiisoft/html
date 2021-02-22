<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Objects\TestInputTag;

final class InputTagTest extends TestCase
{
    public function dataName(): array
    {
        return [
            ['<input>', null],
            ['<input name="count">', 'count'],
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expected, ?string $name): void
    {
        self::assertSame($expected, (string)TestInputTag::tag()->name($name));
    }

    public function dataValue(): array
    {
        return [
            'null' => ['<input>', null],
            'string' => ['<input value="hello">', 'hello'],
            'stringable' => ['<input value="string">', new StringableObject()],
            'int' => ['<input value="42">', 42],
            'float' => ['<input value="42.56">', 42.56],
            'float-zero' => ['<input value="42">', 42.00],
            'true' => ['<input value>', true],
            'false' => ['<input>', false],
        ];
    }

    /**
     * @dataProvider dataValue
     *
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function testValue(string $expected, $value): void
    {
        self::assertSame($expected, (string)TestInputTag::tag()->value($value));
    }

    public function dataForm(): array
    {
        return [
            ['<input>', null],
            ['<input form="">', ''],
            ['<input form="post">', 'post'],
        ];
    }

    /**
     * @dataProvider dataForm
     */
    public function testForm(string $expected, ?string $formId): void
    {
        self::assertSame($expected, TestInputTag::tag()->form($formId)->render());
    }

    public function testReadonly(): void
    {
        self::assertSame('<input readonly>', (string)TestInputTag::tag()->readonly());
        self::assertSame('<input>', (string)TestInputTag::tag()->readonly(false));
        self::assertSame('<input>', (string)TestInputTag::tag()->readonly(true)->readonly(false));
    }

    public function testRequired(): void
    {
        self::assertSame('<input required>', (string)TestInputTag::tag()->required());
        self::assertSame('<input>', (string)TestInputTag::tag()->required(false));
        self::assertSame('<input>', (string)TestInputTag::tag()->required(true)->required(false));
    }

    public function testDisabled(): void
    {
        self::assertSame('<input disabled>', (string)TestInputTag::tag()->disabled());
        self::assertSame('<input>', (string)TestInputTag::tag()->disabled(false));
        self::assertSame('<input>', (string)TestInputTag::tag()->disabled(true)->disabled(false));
    }

    public function testImmutability(): void
    {
        $input = TestInputTag::tag();
        self::assertNotSame($input, $input->name(null));
        self::assertNotSame($input, $input->value(null));
        self::assertNotSame($input, $input->form(null));
        self::assertNotSame($input, $input->readonly());
        self::assertNotSame($input, $input->required());
        self::assertNotSame($input, $input->disabled());
    }
}
