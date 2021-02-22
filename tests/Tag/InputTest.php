<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input;

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

    public function testImmutability(): void
    {
        $input = Input::tag();
        self::assertNotSame($input, $input->type(null));
    }
}
