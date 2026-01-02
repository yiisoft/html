<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestBooleanInputTag;

final class BooleanInputTagTest extends TestCase
{
    public function testChecked(): void
    {
        $this->assertSame('<input checked type="test">', (string) TestBooleanInputTag::tag()->checked());
        $this->assertSame('<input type="test">', (string) TestBooleanInputTag::tag()->checked(false));
        $this->assertSame('<input type="test">', (string) TestBooleanInputTag::tag()
            ->checked(true)
            ->checked(false));
    }

    public static function dataLabel(): array
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
            [
                '<label><input type="test"></label>',
                '',
                [],
            ],
            [
                '<input type="test">',
                null,
                [],
            ],
        ];
    }

    #[DataProvider('dataLabel')]
    public function testLabel(string $expected, ?string $label, array $attributes): void
    {
        $this->assertSame(
            $expected,
            TestBooleanInputTag::tag()
                ->label($label, $attributes)
                ->render(),
        );
    }

    public function testLabelNoWrap(): void
    {
        $this->assertSame(
            '<input id="ID" type="test"> <label for="ID">Voronezh</label>',
            (string) TestBooleanInputTag::tag()
                ->id('ID')
                ->label('Voronezh', wrap: false),
        );
    }

    public function testLabelWithId(): void
    {
        $this->assertSame(
            '<label><input id="Test" type="test"> One</label>',
            TestBooleanInputTag::tag()
                ->id('Test')
                ->label('One')
                ->render(),
        );
    }

    public function testSideLabel(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label for="i\1">One</label>~',
            TestBooleanInputTag::tag()
                ->sideLabel('One')
                ->render(),
        );
    }

    public function testSideLabelEmpty(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label for="i\1"></label>~',
            TestBooleanInputTag::tag()
                ->sideLabel('')
                ->render(),
        );
    }

    public function testSideLabelNull(): void
    {
        $this->assertSame(
            '<input type="test">',
            TestBooleanInputTag::tag()
                ->sideLabel(null)
                ->render(),
        );
    }

    public function testSideLabelWithId(): void
    {
        $this->assertSame(
            '<input id="Test" type="test"> <label for="Test">One</label>',
            TestBooleanInputTag::tag()
                ->id('Test')
                ->sideLabel('One')
                ->render(),
        );
    }

    public function testSideLabelWithAttributes(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label class="red" for="i\1">One</label>~',
            TestBooleanInputTag::tag()
                ->sideLabel('One', ['class' => 'red'])
                ->render(),
        );
    }

    public function testSideLabelId(): void
    {
        $this->assertSame(
            '<input id="count" type="test"> <label for="count">One</label>',
            TestBooleanInputTag::tag()
                ->sideLabel('One')
                ->id('count')
                ->render(),
        );
    }

    public function testWithoutLabelEncode(): void
    {
        $this->assertSame(
            '<label><input type="test"> <b>One</b></label>',
            TestBooleanInputTag::tag()
                ->label('<b>One</b>')
                ->labelEncode(false)
                ->render(),
        );
    }

    public static function dataUncheckValue(): array
    {
        return [
            ['<input type="test">', null, null],
            ['<input type="test">', null, 7],
            ['<input name="color" type="test">', 'color', null],
            ['<input name="color[]" type="test">', 'color[]', null],
            [
                '<input type="hidden" name="color" value="7"><input name="color" type="test">',
                'color',
                7,
            ],
            [
                '<input type="hidden" name="color" value="7"><input name="color[]" type="test">',
                'color[]',
                7,
            ],
        ];
    }

    #[DataProvider('dataUncheckValue')]
    public function testUncheckValue(string $expected, ?string $name, $value): void
    {
        $this->assertSame(
            $expected,
            TestBooleanInputTag::tag()
                ->name($name)
                ->uncheckValue($value)
                ->render(),
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7" disabled>'
            . '<input name="color" disabled type="test">',
            TestBooleanInputTag::tag()
                ->name('color')
                ->uncheckValue(7)
                ->disabled()
                ->render(),
        );
    }

    public function testUncheckValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7" form="post">'
            . '<input name="color" form="post" type="test">',
            TestBooleanInputTag::tag()
                ->name('color')
                ->uncheckValue(7)
                ->form('post')
                ->render(),
        );
    }

    public function testUncheckValueWithLabel(): void
    {
        $this->assertSame(
            '<input type="hidden" name="color" value="7">'
            . '<label><input name="color" type="test"> Seven</label>',
            TestBooleanInputTag::tag()
                ->name('color')
                ->uncheckValue(7)
                ->label('Seven')
                ->render(),
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
