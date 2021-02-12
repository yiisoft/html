<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select;

final class SelectTest extends TestCase
{
    public function dataName(): array
    {
        return [
            ['<select></select>', null],
            ['<select name="age"></select>', 'age'],
            ['<select name="place[]"></select>', 'place[]'],
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expected, ?string $name): void
    {
        self::assertSame($expected, (string)Select::tag()->name($name));
    }

    public function dataNameForMultiple(): array
    {
        return [
            ['<select multiple></select>', null],
            ['<select name="" multiple></select>', ''],
            ['<select name="age[]" multiple></select>', 'age'],
            ['<select name="place[]" multiple></select>', 'place[]'],
        ];
    }

    /**
     * @dataProvider dataNameForMultiple
     */
    public function testNameForMultiple(string $expected, ?string $name): void
    {
        self::assertSame($expected, (string)Select::tag()->multiple()->name($name));
    }

    public function dataValue(): array
    {
        return [
            ['<select></select>', [], []],
            ['<select></select>', [], [42]],
            [
                '<select><option value="1"></option><option value="2"></option></select>',
                [Option::tag()->value('1'), Option::tag()->value('2')->selected()],
                [],
            ],
            [
                '<select><option value="1"></option><option value="2"></option></select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [7],
            ],
            [
                '<select><option value="1" selected></option><option value="2"></option></select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1],
            ],
            [
                '<select><option value="1"></option><option value="2" selected></option></select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                ['2'],
            ],
            [
                '<select><option value="1" selected></option><option value="2" selected></option></select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1, 2],
            ],
            [
                '<select>' .
                '<option value="1">One</option>' .
                '<optgroup>' .
                '<option value="1.1">One.One</option>' .
                '<option value="1.2">One.Two</option>' .
                '</optgroup>' .
                '</select>',
                [
                    Option::tag()->value('1')->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()->value('1.1')->content('One.One'),
                        Option::tag()->value('1.2')->content('One.Two'),
                    ),
                ],
                [],
            ],
            [
                '<select>' .
                '<option value="1" selected>One</option>' .
                '<optgroup>' .
                '<option value="1.1" selected>One.One</option>' .
                '<option value="1.2">One.Two</option>' .
                '</optgroup>' .
                '</select>',
                [
                    Option::tag()->value('1')->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()->value('1.1')->content('One.One'),
                        Option::tag()->value('1.2')->content('One.Two'),
                    ),
                ],
                ['1', '1.1'],
            ],
        ];
    }

    /**
     * @dataProvider dataValue
     */
    public function testValue(string $expected, array $items, array $value): void
    {
        self::assertSame(
            $expected,
            (string)Select::tag()->items(...$items)->value(...$value)->separator(''),
        );
        self::assertSame(
            $expected,
            (string)Select::tag()->items(...$items)->values($value)->separator(''),
        );
    }

    public function testIncorrectValues(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Select::tag()->values('42');
    }

    public function dataForm(): array
    {
        return [
            ['<select></select>', null],
            ['<select form=""></select>', ''],
            ['<select form="post"></select>', 'post'],
        ];
    }

    /**
     * @dataProvider dataForm
     */
    public function testForm(string $expected, ?string $formId): void
    {
        self::assertSame($expected, Select::tag()->form($formId)->render());
    }

    public function dataItems(): array
    {
        return [
            [
                '<select></select>',
                [],
            ],
            [
                '<select><option value="1">One</option><option value="2">Two</option></select>',
                [
                    Option::tag()->value('1')->content('One'),
                    Option::tag()->value('2')->content('Two'),
                ],
            ],
            [
                '<select>' .
                '<option value="1">One</option>' .
                '<optgroup><option value="1.1">One.One</option><option value="1.2">One.Two</option></optgroup>' .
                '</select>',
                [
                    Option::tag()->value('1')->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()->value('1.1')->content('One.One'),
                        Option::tag()->value('1.2')->content('One.Two'),
                    ),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataItems
     */
    public function testItems(string $expected, array $items): void
    {
        self::assertSame($expected, (string)Select::tag()->items(...$items)->separator(''));
    }

    public function testIncorrectItems(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Incorrect item into Select.');
        Select::tag()->items(Li::tag())->render();
    }

    public function testOptions(): void
    {
        self::assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string)Select::tag()
                ->options(
                    Option::tag()->value('1')->content('One'),
                    Option::tag()->value('2')->content('Two'),
                )
        );
    }

    public function testOptionsData(): void
    {
        self::assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string)Select::tag()->optionsData(['1' => 'One', '2' => 'Two'])
        );
    }

    public function testOptionsDataEncode(): void
    {
        self::assertSame(
            "<select>\n<option value=\"1\">&lt;b&gt;One&lt;/b&gt;</option>\n</select>",
            (string)Select::tag()->optionsData(['1' => '<b>One</b>'])
        );
    }

    public function testOptionsDataWithoutEncode(): void
    {
        self::assertSame(
            "<select>\n<option value=\"1\"><b>One</b></option>\n</select>",
            (string)Select::tag()->optionsData(['1' => '<b>One</b>'], false)
        );
    }

    public function dataPrompt(): array
    {
        return [
            [
                '<select><option value="1">One</option></select>',
                null,
            ],
            [
                '<select><option value="">Please select...</option><option value="1">One</option></select>',
                'Please select...',
            ],
        ];
    }

    /**
     * @dataProvider dataPrompt
     */
    public function testPrompt(string $expected, ?string $text): void
    {
        self::assertSame(
            $expected,
            (string)Select::tag()
                ->prompt($text)
                ->options(Option::tag()->value('1')->content('One'))
                ->separator('')
        );
    }

    public function dataPromptOption(): array
    {
        return [
            [
                '<select><option value="1">One</option></select>',
                null,
            ],
            [
                '<select><option>Please select...</option><option value="1">One</option></select>',
                Option::tag()->content('Please select...'),
            ],
        ];
    }

    /**
     * @dataProvider dataPromptOption
     */
    public function testPromptOption(string $expected, ?Option $option): void
    {
        self::assertSame(
            $expected,
            (string)Select::tag()
                ->promptOption($option)
                ->options(Option::tag()->value('1')->content('One'))
                ->separator('')
        );
    }

    public function testDisabled(): void
    {
        self::assertSame('<select disabled></select>', (string)Select::tag()->disabled());
        self::assertSame('<select></select>', (string)Select::tag()->disabled(false));
        self::assertSame('<select></select>', (string)Select::tag()->disabled(true)->disabled(false));
    }

    public function testMultiple(): void
    {
        self::assertSame('<select multiple></select>', (string)Select::tag()->multiple());
        self::assertSame('<select></select>', (string)Select::tag()->multiple(false));
        self::assertSame('<select></select>', (string)Select::tag()->multiple(true)->multiple(false));
    }

    public function testRequired(): void
    {
        self::assertSame('<select required></select>', (string)Select::tag()->required());
        self::assertSame('<select></select>', (string)Select::tag()->required(false));
        self::assertSame('<select></select>', (string)Select::tag()->required(true)->required(false));
    }

    public function dataSize(): array
    {
        return [
            ['<select></select>', null],
            ['<select size="4"></select>', 4],
        ];
    }

    /**
     * @dataProvider dataSize
     */
    public function testSize(string $expected, ?int $size): void
    {
        self::assertSame($expected, (string)Select::tag()->size($size));
    }

    public function dataUnselectValue(): array
    {
        return [
            ['<select></select>', null, null],
            ['<select></select>', null, 7],
            ['<select name="test"></select>', 'test', null],
            ['<select name="test[]"></select>', 'test[]', null],
            [
                '<input type="hidden" name="test" value="7"><select name="test"></select>',
                'test',
                7,
            ],
            [
                '<input type="hidden" name="test" value="7"><select name="test[]"></select>',
                'test[]',
                7,
            ],
        ];
    }

    /**
     * @dataProvider dataUnselectValue
     *
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function testUnselectValue(string $expected, ?string $name, $value): void
    {
        self::assertSame(
            $expected,
            Select::tag()->name($name)->unselectValue($value)->separator('')->render()
        );
    }

    public function testUnselectValueDisabled(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="7" disabled>' . "\n" .
            '<select name="test" disabled></select>',
            Select::tag()->name('test')->unselectValue(7)->disabled()->render()
        );
    }

    public function testUnselectValueForm(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="7" form="post">' . "\n" .
            '<select name="test" form="post"></select>',
            Select::tag()->name('test')->unselectValue(7)->form('post')->render()
        );
    }

    public function testUnselectValueMultiple(): void
    {
        self::assertSame(
            '<select name="test[]" multiple></select>',
            Select::tag()->name('test')->unselectValue(7)->multiple()->render()
        );
    }

    public function testSeparator(): void
    {
        self::assertSame(
            '<select>' . "\r" .
            '<option value="1">One</option>' . "\r" .
            '<option value="2">Two</option>' . "\r" .
            '</select>',
            (string)Select::tag()
                ->optionsData(['1' => 'One', '2' => 'Two'])
                ->separator("\r")
        );
    }

    public function testImmutability(): void
    {
        $select = Select::tag();
        self::assertNotSame($select, $select->name(''));
        self::assertNotSame($select, $select->value());
        self::assertNotSame($select, $select->values([]));
        self::assertNotSame($select, $select->form(null));
        self::assertNotSame($select, $select->items());
        self::assertNotSame($select, $select->options());
        self::assertNotSame($select, $select->optionsData([]));
        self::assertNotSame($select, $select->prompt(''));
        self::assertNotSame($select, $select->promptOption(Option::tag()));
        self::assertNotSame($select, $select->disabled());
        self::assertNotSame($select, $select->multiple());
        self::assertNotSame($select, $select->required());
        self::assertNotSame($select, $select->size(0));
        self::assertNotSame($select, $select->unselectValue(null));
        self::assertNotSame($select, $select->separator(''));
    }
}
