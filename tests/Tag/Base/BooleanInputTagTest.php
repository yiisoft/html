<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\IdGenerator;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Objects\TestBooleanInputTag;

final class BooleanInputTagTest extends TestCase
{
    public function testChecked(): void
    {
        $this->assertSame('<input checked type="test">', (string) (new TestBooleanInputTag())->checked());
        $this->assertSame('<input type="test">', (string) (new TestBooleanInputTag())->checked(false));
        $this->assertSame('<input type="test">', (string) (new TestBooleanInputTag())
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
            (new TestBooleanInputTag())
                ->label($label, $attributes)
                ->render(),
        );
    }

    public function testLabelNoWrap(): void
    {
        $this->assertSame(
            '<input id="ID" type="test"> <label for="ID">Voronezh</label>',
            (string) (new TestBooleanInputTag())
                ->id('ID')
                ->label('Voronezh', wrap: false),
        );
    }

    public function testLabelWithId(): void
    {
        $this->assertSame(
            '<label><input id="Test" type="test"> One</label>',
            (new TestBooleanInputTag())
                ->id('Test')
                ->label('One')
                ->render(),
        );
    }

    public function testSideLabel(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label for="i\1">One</label>~',
            (new TestBooleanInputTag())
                ->sideLabel('One')
                ->render(),
        );
    }

    public function testSideLabelEmpty(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label for="i\1"></label>~',
            (new TestBooleanInputTag())
                ->sideLabel('')
                ->render(),
        );
    }

    public function testSideLabelNull(): void
    {
        $this->assertSame(
            '<input type="test">',
            (new TestBooleanInputTag())
                ->sideLabel(null)
                ->render(),
        );
    }

    public function testSideLabelWithId(): void
    {
        $this->assertSame(
            '<input id="Test" type="test"> <label for="Test">One</label>',
            (new TestBooleanInputTag())
                ->id('Test')
                ->sideLabel('One')
                ->render(),
        );
    }

    public function testSideLabelWithAttributes(): void
    {
        $this->assertMatchesRegularExpression(
            '~<input id="i(\d*?)" type="test"> <label class="red" for="i\1">One</label>~',
            (new TestBooleanInputTag())
                ->sideLabel('One', ['class' => 'red'])
                ->render(),
        );
    }

    public function testSideLabelId(): void
    {
        $this->assertSame(
            '<input id="count" type="test"> <label for="count">One</label>',
            (new TestBooleanInputTag())
                ->sideLabel('One')
                ->id('count')
                ->render(),
        );
    }

    public function testWithoutLabelEncode(): void
    {
        $this->assertSame(
            '<label><input type="test"> <b>One</b></label>',
            (new TestBooleanInputTag())
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
            (new TestBooleanInputTag())
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
            (new TestBooleanInputTag())
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
            (new TestBooleanInputTag())
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
            (new TestBooleanInputTag())
                ->name('color')
                ->uncheckValue(7)
                ->label('Seven')
                ->render(),
        );
    }

    public static function dataBeforeInput(): iterable
    {
        yield [
            'Before',
            'Before',
        ];
        yield [
            '<span>Before</span>',
            '<span>Before</span>',
        ];
        yield [
            'Before',
            new StringableObject('Before'),
        ];
        yield [
            '<span>Before</span>',
            new StringableObject('<span>Before</span>'),
        ];
    }

    #[DataProvider('dataBeforeInput')]
    public function testBeforeInput(string $expectedBefore, string|Stringable $content): void
    {
        $input = (new TestBooleanInputTag())->beforeInput($content);
        $this->assertSame(
            $expectedBefore . '<input type="test">',
            (string) $input,
        );
    }

    public function testBeforeInputWithLabel(): void
    {
        $input = (new TestBooleanInputTag())
            ->label('One')
            ->beforeInput('Before');
        $this->assertSame(
            '<label>Before<input type="test"> One</label>',
            (string) $input,
        );
    }

    public function testBeforeInputWithSideLabel(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        try {
            $result = (new TestBooleanInputTag())
                ->sideLabel('One')
                ->beforeInput('Before')
                ->render();
        } finally {
            IdGenerator\enableSeed();
        }

        $this->assertSame(
            'Before<input id="i1" type="test"> <label for="i1">One</label>',
            $result,
        );
    }

    public static function dataAfterInput(): iterable
    {
        yield [
            'After',
            'After',
        ];
        yield [
            '<span>After</span>',
            '<span>After</span>',
        ];
        yield [
            'After',
            new StringableObject('After'),
        ];
        yield [
            '<span>After</span>',
            new StringableObject('<span>After</span>'),
        ];
    }

    #[DataProvider('dataAfterInput')]
    public function testAfterInput(string $expectedAfter, string|Stringable $content): void
    {
        $input = (new TestBooleanInputTag())->AfterInput($content);
        $this->assertSame(
            '<input type="test">' . $expectedAfter,
            (string) $input,
        );
    }

    public function testAfterInputWithLabel(): void
    {
        $input = (new TestBooleanInputTag())
            ->label('One')
            ->afterInput('After');
        $this->assertSame(
            '<label><input type="test">After One</label>',
            (string) $input,
        );
    }

    public function testAfterInputWithSideLabel(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        try {
            $result = (new TestBooleanInputTag())
                ->sideLabel('One')
                ->afterInput('After')
                ->render();
        } finally {
            IdGenerator\enableSeed();
        }

        $this->assertSame(
            '<input id="i1" type="test">After <label for="i1">One</label>',
            $result,
        );
    }

    public function testImmutability(): void
    {
        $input = new TestBooleanInputTag();
        $this->assertNotSame($input, $input->checked());
        $this->assertNotSame($input, $input->label(''));
        $this->assertNotSame($input, $input->sideLabel(''));
        $this->assertNotSame($input, $input->labelEncode(true));
        $this->assertNotSame($input, $input->uncheckValue(null));
        $this->assertNotSame($input, $input->beforeInput(''));
        $this->assertNotSame($input, $input->afterInput(''));
    }
}
