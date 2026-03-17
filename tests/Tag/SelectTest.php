<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Support\IntegerEnum;
use Yiisoft\Html\Tests\Support\StringEnum;

use function PHPUnit\Framework\assertSame;

final class SelectTest extends TestCase
{
    public static function dataProviderName(): array
    {
        return [
            ['<select></select>', null],
            ['<select name="age"></select>', 'age'],
            ['<select name="place[]"></select>', 'place[]'],
        ];
    }

    #[DataProvider('dataProviderName')]
    public function testName(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) (new Select())->name($name));
    }

    public static function dataNameForMultiple(): array
    {
        return [
            ['<select multiple></select>', null],
            ['<select multiple name></select>', ''],
            [
                '<input type="hidden" name="age" value>' . "\n"
                . '<select multiple name="age[]"></select>',
                'age',
            ],
            [
                '<input type="hidden" name="place" value>' . "\n"
                . '<select multiple name="place[]"></select>',
                'place[]',
            ],
        ];
    }

    #[DataProvider('dataNameForMultiple')]
    public function testNameForMultiple(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) (new Select())
            ->multiple()
            ->name($name));
    }

    public static function dataValue(): array
    {
        return [
            ['<select></select>', [], []],
            ['<select></select>', [], [42]],
            [
                '<select>' . "\n"
                . '<option value="1"></option>' . "\n"
                . '<option value="2"></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())
                    ->value('2')
                    ->selected(), ],
                [],
            ],
            [
                '<select>' . "\n"
                . '<option value="1"></option>' . "\n"
                . '<option value="2"></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [7],
            ],
            [
                '<select>' . "\n"
                . '<option value="1" selected></option>' . "\n"
                . '<option value="2"></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [1],
            ],
            [
                '<select>' . "\n"
                . '<option value="1"></option>' . "\n"
                . '<option value="2" selected></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                ['2'],
            ],
            [
                '<select>' . "\n"
                . '<option value="1" selected></option>' . "\n"
                . '<option value="2" selected></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [1, 2],
            ],
            [
                '<select>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '<optgroup>' . "\n"
                . '<option value="1.1">One.One</option>' . "\n"
                . '<option value="1.2">One.Two</option>' . "\n"
                . '</optgroup>' . "\n"
                . '</select>',
                [
                    (new Option())
                        ->value('1')
                        ->content('One'),
                    (new Optgroup())->options(
                        (new Option())
                            ->value('1.1')
                            ->content('One.One'),
                        (new Option())
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
                [],
            ],
            [
                '<select>' . "\n"
                . '<option value="1" selected>One</option>' . "\n"
                . '<optgroup>' . "\n"
                . '<option value="1.1" selected>One.One</option>' . "\n"
                . '<option value="1.2">One.Two</option>' . "\n"
                . '</optgroup>' . "\n"
                . '</select>',
                [
                    (new Option())
                        ->value('1')
                        ->content('One'),
                    (new Optgroup())->options(
                        (new Option())
                            ->value('1.1')
                            ->content('One.One'),
                        (new Option())
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
                ['1', '1.1'],
            ],
            ['<select></select>', [], [IntegerEnum::A]],
            ['<select></select>', [], [StringEnum::A]],
            [
                '<select>' . "\n"
                . '<option value="1"></option>' . "\n"
                . '<option value="2"></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [IntegerEnum::C],
            ],
            [
                '<select>' . "\n"
                . '<option value="1" selected></option>' . "\n"
                . '<option value="2"></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [IntegerEnum::A],
            ],
            [
                '<select>' . "\n"
                . '<option value="1" selected></option>' . "\n"
                . '<option value="2" selected></option>' . "\n"
                . '</select>',
                [(new Option())->value('1'), (new Option())->value('2')],
                [IntegerEnum::A, IntegerEnum::B],
            ],
            [
                '<select>' . "\n"
                . '<option value="one"></option>' . "\n"
                . '<option value="two" selected></option>' . "\n"
                . '</select>',
                [(new Option())->value('one'), (new Option())->value('two')],
                [StringEnum::B],
            ],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, array $items, array $value): void
    {
        $this->assertSame(
            $expected,
            (string) (new Select())->items(...$items)->value(...$value),
        );
        $this->assertSame(
            $expected,
            (string) (new Select())->items(...$items)->values($value),
        );
    }

    public static function dataForm(): array
    {
        return [
            ['<select></select>', null],
            ['<select form></select>', ''],
            ['<select form="post"></select>', 'post'],
        ];
    }

    #[DataProvider('dataForm')]
    public function testForm(string $expected, ?string $formId): void
    {
        $this->assertSame($expected, (new Select())
            ->form($formId)
            ->render());
    }

    public static function dataItems(): array
    {
        return [
            [
                '<select></select>',
                [],
            ],
            [
                '<select>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '<option value="2">Two</option>' . "\n"
                . '</select>',
                [
                    (new Option())
                        ->value('1')
                        ->content('One'),
                    (new Option())
                        ->value('2')
                        ->content('Two'),
                ],
            ],
            [
                '<select>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '<optgroup>' . "\n"
                . '<option value="1.1">One.One</option>' . "\n"
                . '<option value="1.2">One.Two</option>' . "\n"
                . '</optgroup>' . "\n"
                . '</select>',
                [
                    (new Option())
                        ->value('1')
                        ->content('One'),
                    (new Optgroup())->options(
                        (new Option())
                            ->value('1.1')
                            ->content('One.One'),
                        (new Option())
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
            ],
        ];
    }

    #[DataProvider('dataItems')]
    public function testItems(string $expected, array $items): void
    {
        $this->assertSame($expected, (string) (new Select())->items(...$items));
    }

    public function testOptions(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string) (new Select())
                ->options(
                    (new Option())
                        ->value('1')
                        ->content('One'),
                    (new Option())
                        ->value('2')
                        ->content('Two'),
                ),
        );
    }

    public function testOptionsData(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string) (new Select())->optionsData(['1' => 'One', '2' => 'Two']),
        );
        $this->assertSame(
            "<select>\n<option value=\"1\">42</option>\n<option value=\"2\">3.14</option>\n</select>",
            (string) (new Select())->optionsData(['1' => 42, '2' => 3.14]),
        );
    }

    public function testOptionsDataEncode(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">&lt;b&gt;One&lt;/b&gt;</option>\n</select>",
            (string) (new Select())->optionsData(['1' => '<b>One</b>']),
        );
    }

    public function testOptionsDataWithoutEncode(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\"><b>One</b></option>\n</select>",
            (string) (new Select())->optionsData(['1' => '<b>One</b>'], false),
        );
    }

    public function testOptionsDataWithGroups(): void
    {
        $tag = (new Select())
            ->optionsData([
                1 => 'One',
                'Test Group' => [
                    2 => 'Two',
                    3 => 'Three',
                ],
            ]);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <select>
            <option value="1">One</option>
            <optgroup label="Test Group">
            <option value="2">Two</option>
            <option value="3">Three</option>
            </optgroup>
            </select>
            HTML,
            $tag->render(),
        );
    }

    public function testOptionsAndGroupsAttributes(): void
    {
        $tag = (new Select())
            ->optionsData(
                [
                    1 => 'One',
                    'Group A' => [
                        2 => 'Two',
                        3 => 'Three',
                    ],
                    'Group B' => [
                        4 => 'Four',
                        5 => 'Five',
                    ],
                ],
                true,
                [
                    1 => ['data-key' => 42],
                    3 => ['id' => 'UniqueOption'],
                ],
                [
                    'Group B' => ['label' => 'Custom Label', 'data-id' => 'Group B'],
                ],
            );

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <select>
            <option data-key="42" value="1">One</option>
            <optgroup label="Group A">
            <option value="2">Two</option>
            <option id="UniqueOption" value="3">Three</option>
            </optgroup>
            <optgroup label="Custom Label" data-id="Group B">
            <option value="4">Four</option>
            <option value="5">Five</option>
            </optgroup>
            </select>
            HTML,
            $tag->render(),
        );
    }

    public static function dataPrompt(): array
    {
        return [
            [
                '<select>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '</select>',
                null,
            ],
            [
                '<select>' . "\n"
                . '<option value>Please select...</option>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '</select>',
                'Please select...',
            ],
            [
                '<select>' . "\n"
                . '<option value>Choose an option</option>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '</select>',
                new StringableObject('Choose an option'),
            ],
        ];
    }

    #[DataProvider('dataPrompt')]
    public function testPrompt(string $expected, string|Stringable|null $text): void
    {
        $this->assertSame(
            $expected,
            (string) (new Select())
                ->prompt($text)
                ->options((new Option())
                    ->value('1')
                    ->content('One')),
        );
    }

    public static function dataPromptOption(): array
    {
        return [
            [
                '<select>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '</select>',
                null,
            ],
            [
                '<select>' . "\n"
                . '<option>Please select...</option>' . "\n"
                . '<option value="1">One</option>' . "\n"
                . '</select>',
                (new Option())->content('Please select...'),
            ],
        ];
    }

    #[DataProvider('dataPromptOption')]
    public function testPromptOption(string $expected, ?Option $option): void
    {
        $this->assertSame(
            $expected,
            (string) (new Select())
                ->promptOption($option)
                ->options((new Option())
                    ->value('1')
                    ->content('One')),
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<select disabled></select>', (string) (new Select())->disabled());
        $this->assertSame('<select></select>', (string) (new Select())->disabled(false));
        $this->assertSame('<select></select>', (string) (new Select())
            ->disabled(true)
            ->disabled(false));
    }

    public function testMultiple(): void
    {
        $this->assertSame('<select multiple></select>', (string) (new Select())->multiple());
        $this->assertSame('<select></select>', (string) (new Select())->multiple(false));
        $this->assertSame('<select></select>', (string) (new Select())
            ->multiple(true)
            ->multiple(false));
    }

    public function testRequired(): void
    {
        $this->assertSame('<select required></select>', (string) (new Select())->required());
        $this->assertSame('<select></select>', (string) (new Select())->required(false));
        $this->assertSame('<select></select>', (string) (new Select())
            ->required(true)
            ->required(false));
    }

    public static function dataSize(): array
    {
        return [
            ['<select></select>', null],
            ['<select size="4"></select>', 4],
        ];
    }

    #[DataProvider('dataSize')]
    public function testSize(string $expected, ?int $size): void
    {
        $this->assertSame($expected, (string) (new Select())->size($size));
    }

    public static function dataUnselectValue(): array
    {
        return [
            ['<select></select>', null, null],
            ['<select></select>', null, 7],
            ['<select name="test"></select>', 'test', null],
            ['<select name="test[]"></select>', 'test[]', null],
            [
                '<input type="hidden" name="test" value="7">' . "\n"
                . '<select name="test"></select>',
                'test',
                7,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n"
                . '<select name="test[]"></select>',
                'test[]',
                7,
            ],
        ];
    }

    #[DataProvider('dataUnselectValue')]
    public function testUnselectValue(string $expected, ?string $name, $value): void
    {
        $this->assertSame(
            $expected,
            (new Select())
                ->name($name)
                ->unselectValue($value)
                ->render(),
        );
    }

    public function testUnselectValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7" disabled>' . "\n"
            . '<select name="test" disabled></select>',
            (new Select())
                ->name('test')
                ->unselectValue(7)
                ->disabled()
                ->render(),
        );
    }

    public function testUnselectValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7" form="post">' . "\n"
            . '<select name="test" form="post"></select>',
            (new Select())
                ->name('test')
                ->unselectValue(7)
                ->form('post')
                ->render(),
        );
    }

    public function testUnselectValueMultiple(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7">' . "\n"
            . '<select name="test[]" multiple></select>',
            (new Select())
                ->name('test')
                ->unselectValue(7)
                ->multiple()
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $select = new Select();
        $this->assertNotSame($select, $select->name(''));
        $this->assertNotSame($select, $select->value());
        $this->assertNotSame($select, $select->values([]));
        $this->assertNotSame($select, $select->form(null));
        $this->assertNotSame($select, $select->items());
        $this->assertNotSame($select, $select->options());
        $this->assertNotSame($select, $select->optionsData([]));
        $this->assertNotSame($select, $select->prompt(''));
        $this->assertNotSame($select, $select->promptOption(new Option()));
        $this->assertNotSame($select, $select->disabled());
        $this->assertNotSame($select, $select->multiple());
        $this->assertNotSame($select, $select->required());
        $this->assertNotSame($select, $select->size(0));
        $this->assertNotSame($select, $select->unselectValue(null));
    }

    public function testNullValue(): void
    {
        $select = (new Select())
            ->optionsData(['red' => 'RED', 'green' => 'GREEN'])
            ->value(null);

        assertSame(
            <<<HTML
            <select>
            <option value="red">RED</option>
            <option value="green">GREEN</option>
            </select>
            HTML,
            $select->render(),
        );
    }

    public function testNullValueOverride(): void
    {
        $select = (new Select())
            ->optionsData(['red' => 'RED', 'green' => 'GREEN'])
            ->value('red')
            ->value(null);

        assertSame(
            <<<HTML
            <select>
            <option value="red">RED</option>
            <option value="green">GREEN</option>
            </select>
            HTML,
            $select->render(),
        );
    }
}
