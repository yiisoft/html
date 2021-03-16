<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input;

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

    public function testImmutability(): void
    {
        $input = Input::tag();
        $this->assertNotSame($input, $input->type(null));
    }
}
