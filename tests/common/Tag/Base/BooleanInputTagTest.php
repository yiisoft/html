<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestBooleanInputTag;

final class BooleanInputTagTest extends TestCase
{
    public function testChecked(): void
    {
        $this->assertSame('<input type="test" checked>', (string)TestBooleanInputTag::tag()->checked());
        $this->assertSame('<input type="test">', (string)TestBooleanInputTag::tag()->checked(false));
        $this->assertSame('<input type="test">', (string)TestBooleanInputTag::tag()->checked(true)->checked(false));
    }

    public function dataLabel(): array
    {
        return [
            [
                '<label><input type="test"> One</label>',
                'One',
                [],
            ],
            [
                '<label><input type="test"> &lt;b&gt;One&lt;/b&gt;</label>',
                '<b>One</b>',
                [],
            ],
            [
                '<label class="red"><input type="test"> One</label>',
                'One',
                ['class' => 'red'],
            ],
        ];
    }

    /**
     * @dataProvider dataLabel
     */
    public function testLabel(string $expected, string $label, array $attributes): void
    {
        $this->assertSame(
            $expected,
            TestBooleanInputTag::tag()->label($label, $attributes)->render()
        );
    }

    public function testLabelWithId(): void
    {
        $this->assertSame(
            '<label><input type="test" id="Test"> One</label>',
            TestBooleanInputTag::tag()->id('Test')->label('One')->render()
        );
    }

    public function testSideLabel(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input type="test" id="i(\d*?)"> <label for="i\1">One</label>~',
            TestBooleanInputTag::tag()->sideLabel('One')->render()
        );
    }

    public function testSideLabelWithId(): void
    {
        $this->assertSame(
            '<input type="test" id="Test"> <label for="Test">One</label>',
            TestBooleanInputTag::tag()->id('Test')->sideLabel('One')->render()
        );
    }

    public function testSideLabelWithAttributes(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input type="test" id="i(\d*?)"> <label class="red" for="i\1">One</label>~',
            TestBooleanInputTag::tag()->sideLabel('One', ['class' => 'red'])->render()
        );
    }

    public function testSideLabelId(): void
    {
        $this->assertSame(
            '<input type="test" id="count"> <label for="count">One</label>',
            TestBooleanInputTag::tag()->sideLabel('One')->id('count')->render()
        );
    }

    public function testWithoutLabelEncode(): void
    {
        $this->assertSame(
            '<label><input type="test"> <b>One</b></label>',
            TestBooleanInputTag::tag()->label('<b>One</b>')->labelEncode(false)->render()
        );
    }

    public function dataUncheckValue(): array
    {
        return [
            ['<input type="test">', null, null],
            ['<input type="test">', null, 7],
            ['<input type="test" name="color">', 'color', null],
            ['<input type="test" name="color[]">', 'color[]', null],
            [
                '<input type="hidden" name="color" value="7"><input type="test" name="color">',
                'color',
                7,
            ],
            [
                '<input type="hidden" name="color" value="7"><input type="test" name="color[]">',
                'color[]',
                7,
            ],
        ];
    }

    /**
     * @dataProvider dataUncheckValue
     *
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function testUncheckValue(string $expected, ?string $name, $value): void
    {
        $this->assertSame(
            $expected,
            TestBooleanInputTag::tag()->name($name)->uncheckValue($value)->render()
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7" disabled>' .
            '<input type="test" name="color" disabled>',
            TestBooleanInputTag::tag()->name('color')->uncheckValue(7)->disabled()->render()
        );
    }

    public function testUncheckValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7" form="post">' .
            '<input type="test" name="color" form="post">',
            TestBooleanInputTag::tag()->name('color')->uncheckValue(7)->form('post')->render()
        );
    }

    public function testUncheckValueWithLabel(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7">' .
            '<label><input type="test" name="color"> Seven</label>',
            TestBooleanInputTag::tag()
                ->name('color')
                ->uncheckValue(7)
                ->label('Seven')
                ->render()
        );
    }

    public function testImmutability(): void
    {
        $input = TestBooleanInputTag::tag();
        $this->assertNotSame($input, $input->checked());
        $this->assertNotSame($input, $input->label(''));
        $this->assertNotSame($input, $input->sideLabel(''));
        $this->assertNotSame($input, $input->labelEncode(true));
        $this->assertNotSame($input, $input->uncheckValue(null));
    }
}
