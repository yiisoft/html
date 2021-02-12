<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Html\Tests\Objects\StringableObject;

final class InputTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<input type="hidden" name="id" value="42">',
            (string)Input::tag()->type('hidden')->name('id')->value('42')
        );
    }

    public function testHidden(): void
    {
        self::assertSame(
            '<input type="hidden" name="id" value="42">',
            (string)Input::hidden('id', '42')
        );
    }

    public function testText(): void
    {
        self::assertSame(
            '<input type="text" name="name" value="Mike">',
            (string)Input::text('name', 'Mike')
        );
    }

    public function testPassword(): void
    {
        self::assertSame(
            '<input type="password" name="new_password" value="42-7-42">',
            (string)Input::password('new_password', '42-7-42')
        );
    }

    public function testFile(): void
    {
        self::assertSame(
            '<input type="file" name="photo" value="c:\path\">',
            (string)Input::file('photo', 'c:\\path\\')
        );
    }

    public function testCheckbox(): void
    {
        self::assertSame(
            '<input type="checkbox" name="subscribe" checked>',
            (string)Input::checkbox('subscribe')->checked()
        );
    }

    public function testRadio(): void
    {
        self::assertSame(
            '<input type="radio" name="count" value="one">',
            (string)Input::radio('count', 'one')
        );
    }

    public function testButton(): void
    {
        self::assertSame(
            '<input type="button" value="Go!">',
            (string)Input::button('Go!')
        );
    }

    public function testSubmitButton(): void
    {
        self::assertSame(
            '<input type="submit" value="Go!">',
            (string)Input::submitButton('Go!')
        );
    }

    public function testResetButton(): void
    {
        self::assertSame(
            '<input type="reset" value="Go!">',
            (string)Input::resetButton('Go!')
        );
    }

    public function dataType(): array
    {
        return [
            ['<input>', null],
            ['<input type="text">', 'text'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $type): void
    {
        self::assertSame($expected, (string)Input::tag()->type($type));
    }

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
        self::assertSame($expected, (string)Input::tag()->name($name));
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
     * @param \Stringable|string|int|float|bool|null $value
     */
    public function testValue(string $expected, $value): void
    {
        self::assertSame($expected, (string)Input::tag()->value($value));
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
        self::assertSame($expected, Input::tag()->form($formId)->render());
    }

    public function testReadonly(): void
    {
        self::assertSame('<input readonly>', (string)Input::tag()->readonly());
        self::assertSame('<input>', (string)Input::tag()->readonly(false));
        self::assertSame('<input>', (string)Input::tag()->readonly(true)->readonly(false));
    }

    public function testRequired(): void
    {
        self::assertSame('<input required>', (string)Input::tag()->required());
        self::assertSame('<input>', (string)Input::tag()->required(false));
        self::assertSame('<input>', (string)Input::tag()->required(true)->required(false));
    }

    public function testDisabled(): void
    {
        self::assertSame('<input disabled>', (string)Input::tag()->disabled());
        self::assertSame('<input>', (string)Input::tag()->disabled(false));
        self::assertSame('<input>', (string)Input::tag()->disabled(true)->disabled(false));
    }

    public function testChecked(): void
    {
        self::assertSame('<input checked>', (string)Input::tag()->checked());
        self::assertSame('<input>', (string)Input::tag()->checked(false));
        self::assertSame('<input>', (string)Input::tag()->checked(true)->checked(false));
    }

    public function testImmutability(): void
    {
        $input = Input::tag();
        self::assertNotSame($input, $input->type(null));
        self::assertNotSame($input, $input->name(null));
        self::assertNotSame($input, $input->value(null));
        self::assertNotSame($input, $input->form(null));
        self::assertNotSame($input, $input->readonly());
        self::assertNotSame($input, $input->required());
        self::assertNotSame($input, $input->disabled());
        self::assertNotSame($input, $input->checked());
    }
}
