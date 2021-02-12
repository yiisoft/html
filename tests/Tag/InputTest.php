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
        $this->assertSame(
            '<input type="hidden" name="id" value="42">',
            (string)Input::tag()->type('hidden')->name('id')->value('42')
        );
    }

    public function testHidden(): void
    {
        $this->assertSame(
            '<input type="hidden" name="id" value="42">',
            (string)Input::hidden('id', '42')
        );
    }

    public function testText(): void
    {
        $this->assertSame(
            '<input type="text" name="name" value="Mike">',
            (string)Input::text('name', 'Mike')
        );
    }

    public function testPassword(): void
    {
        $this->assertSame(
            '<input type="password" name="new_password" value="42-7-42">',
            (string)Input::password('new_password', '42-7-42')
        );
    }

    public function testFile(): void
    {
        $this->assertSame(
            '<input type="file" name="photo" value="c:\path\">',
            (string)Input::file('photo', 'c:\\path\\')
        );
    }

    public function testCheckbox(): void
    {
        $this->assertSame(
            '<input type="checkbox" name="subscribe" checked>',
            (string)Input::checkbox('subscribe')->checked()
        );
    }

    public function testRadio(): void
    {
        $this->assertSame(
            '<input type="radio" name="count" value="one">',
            (string)Input::radio('count', 'one')
        );
    }

    public function testButton(): void
    {
        $this->assertSame(
            '<input type="button" value="Go!">',
            (string)Input::button('Go!')
        );
    }

    public function testSubmitButton(): void
    {
        $this->assertSame(
            '<input type="submit" value="Go!">',
            (string)Input::submitButton('Go!')
        );
    }

    public function testResetButton(): void
    {
        $this->assertSame(
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
        $this->assertSame($expected, (string)Input::tag()->type($type));
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
        $this->assertSame($expected, (string)Input::tag()->name($name));
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

    public function testReadonly(): void
    {
        $this->assertSame('<input readonly>', (string)Input::tag()->readonly());
        $this->assertSame('<input>', (string)Input::tag()->readonly(false));
        $this->assertSame('<input>', (string)Input::tag()->readonly(true)->readonly(false));
    }

    public function testRequired(): void
    {
        $this->assertSame('<input required>', (string)Input::tag()->required());
        $this->assertSame('<input>', (string)Input::tag()->required(false));
        $this->assertSame('<input>', (string)Input::tag()->required(true)->required(false));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<input disabled>', (string)Input::tag()->disabled());
        $this->assertSame('<input>', (string)Input::tag()->disabled(false));
        $this->assertSame('<input>', (string)Input::tag()->disabled(true)->disabled(false));
    }

    public function testChecked(): void
    {
        $this->assertSame('<input checked>', (string)Input::tag()->checked());
        $this->assertSame('<input>', (string)Input::tag()->checked(false));
        $this->assertSame('<input>', (string)Input::tag()->checked(true)->checked(false));
    }

    public function testImmutability(): void
    {
        $input = Input::tag();
        $this->assertNotSame($input, $input->type(null));
        $this->assertNotSame($input, $input->name(null));
        $this->assertNotSame($input, $input->value(null));
        $this->assertNotSame($input, $input->readonly());
        $this->assertNotSame($input, $input->required());
        $this->assertNotSame($input, $input->disabled());
        $this->assertNotSame($input, $input->checked());
    }
}
