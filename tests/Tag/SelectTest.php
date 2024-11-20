<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select;
use Yiisoft\Html\Tests\Support\IntegerEnum;
use Yiisoft\Html\Tests\Support\StringEnum;

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
        $this->assertSame($expected, (string)Select::tag()->name($name));
    }

    public static function dataNameForMultiple(): array
    {
        return [
            ['<select multiple></select>', null],
            ['<select name multiple></select>', ''],
            [
                '<input type="hidden" name="age" value>' . "\n" .
                '<select name="age[]" multiple></select>',
                'age',
            ],
            [
                '<input type="hidden" name="place" value>' . "\n" .
                '<select name="place[]" multiple></select>',
                'place[]',
            ],
        ];
    }

    #[DataProvider('dataNameForMultiple')]
    public function testNameForMultiple(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string)Select::tag()
            ->multiple()
            ->name($name));
    }

    public static function dataValue(): array
    {
        return [
            ['<select></select>', [], []],
            ['<select></select>', [], [42]],
            [
                '<select>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()
                    ->value('2')
                    ->selected(), ],
                [],
            ],
            [
                '<select>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [7],
            ],
            [
                '<select>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1],
            ],
            [
                '<select>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2" selected></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                ['2'],
            ],
            [
                '<select>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2" selected></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1, 2],
            ],
            [
                '<select>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '<optgroup>' . "\n" .
                '<option value="1.1">One.One</option>' . "\n" .
                '<option value="1.2">One.Two</option>' . "\n" .
                '</optgroup>' . "\n" .
                '</select>',
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()
                            ->value('1.1')
                            ->content('One.One'),
                        Option::tag()
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
                [],
            ],
            [
                '<select>' . "\n" .
                '<option value="1" selected>One</option>' . "\n" .
                '<optgroup>' . "\n" .
                '<option value="1.1" selected>One.One</option>' . "\n" .
                '<option value="1.2">One.Two</option>' . "\n" .
                '</optgroup>' . "\n" .
                '</select>',
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()
                            ->value('1.1')
                            ->content('One.One'),
                        Option::tag()
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
                ['1', '1.1'],
            ],
            ['<select></select>', [], [IntegerEnum::A]],
            ['<select></select>', [], [StringEnum::A]],
            [
                '<select>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [IntegerEnum::C],
            ],
            [
                '<select>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [IntegerEnum::A],
            ],
            [
                '<select>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2" selected></option>' . "\n" .
                '</select>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [IntegerEnum::A, IntegerEnum::B],
            ],
            [
                '<select>' . "\n" .
                '<option value="one"></option>' . "\n" .
                '<option value="two" selected></option>' . "\n" .
                '</select>',
                [Option::tag()->value('one'), Option::tag()->value('two')],
                [StringEnum::B],
            ],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, array $items, array $value): void
    {
        $this->assertSame(
            $expected,
            (string) Select::tag()->items(...$items)->value(...$value),
        );
        $this->assertSame(
            $expected,
            (string) Select::tag()->items(...$items)->values($value),
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
        $this->assertSame($expected, Select::tag()
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
                '<select>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '<option value="2">Two</option>' . "\n" .
                '</select>',
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Option::tag()
                        ->value('2')
                        ->content('Two'),
                ],
            ],
            [
                '<select>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '<optgroup>' . "\n" .
                '<option value="1.1">One.One</option>' . "\n" .
                '<option value="1.2">One.Two</option>' . "\n" .
                '</optgroup>' . "\n" .
                '</select>',
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()
                            ->value('1.1')
                            ->content('One.One'),
                        Option::tag()
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
        $this->assertSame($expected, (string)Select::tag()->items(...$items));
    }

    public function testOptions(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string)Select::tag()
                ->options(
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Option::tag()
                        ->value('2')
                        ->content('Two'),
                )
        );
    }

    public function testOptionsData(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</select>",
            (string)Select::tag()->optionsData(['1' => 'One', '2' => 'Two'])
        );
    }

    public function testOptionsDataEncode(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\">&lt;b&gt;One&lt;/b&gt;</option>\n</select>",
            (string)Select::tag()->optionsData(['1' => '<b>One</b>'])
        );
    }

    public function testOptionsDataWithoutEncode(): void
    {
        $this->assertSame(
            "<select>\n<option value=\"1\"><b>One</b></option>\n</select>",
            (string)Select::tag()->optionsData(['1' => '<b>One</b>'], false)
        );
    }

    public function testOptionsDataWithGroups(): void
    {
        $tag = Select::tag()
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
            $tag->render()
        );
    }

    public function testOptionsAndGroupsAttributes(): void
    {
        $tag = Select::tag()
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
                ]
            );

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <select>
            <option value="1" data-key="42">One</option>
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
            $tag->render()
        );
    }

    public static function dataPrompt(): array
    {
        return [
            [
                '<select>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '</select>',
                null,
            ],
            [
                '<select>' . "\n" .
                '<option value>Please select...</option>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '</select>',
                'Please select...',
            ],
        ];
    }

    #[DataProvider('dataPrompt')]
    public function testPrompt(string $expected, ?string $text): void
    {
        $this->assertSame(
            $expected,
            (string)Select::tag()
                ->prompt($text)
                ->options(Option::tag()
                    ->value('1')
                    ->content('One'))
        );
    }

    public static function dataPromptOption(): array
    {
        return [
            [
                '<select>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '</select>',
                null,
            ],
            [
                '<select>' . "\n" .
                '<option>Please select...</option>' . "\n" .
                '<option value="1">One</option>' . "\n" .
                '</select>',
                Option::tag()->content('Please select...'),
            ],
        ];
    }

    #[DataProvider('dataPromptOption')]
    public function testPromptOption(string $expected, ?Option $option): void
    {
        $this->assertSame(
            $expected,
            (string)Select::tag()
                ->promptOption($option)
                ->options(Option::tag()
                    ->value('1')
                    ->content('One'))
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<select disabled></select>', (string)Select::tag()->disabled());
        $this->assertSame('<select></select>', (string)Select::tag()->disabled(false));
        $this->assertSame('<select></select>', (string)Select::tag()
            ->disabled(true)
            ->disabled(false));
    }

    public function testMultiple(): void
    {
        $this->assertSame('<select multiple></select>', (string)Select::tag()->multiple());
        $this->assertSame('<select></select>', (string)Select::tag()->multiple(false));
        $this->assertSame('<select></select>', (string)Select::tag()
            ->multiple(true)
            ->multiple(false));
    }

    public function testRequired(): void
    {
        $this->assertSame('<select required></select>', (string)Select::tag()->required());
        $this->assertSame('<select></select>', (string)Select::tag()->required(false));
        $this->assertSame('<select></select>', (string)Select::tag()
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
        $this->assertSame($expected, (string)Select::tag()->size($size));
    }

    public static function dataUnselectValue(): array
    {
        return [
            ['<select></select>', null, null],
            ['<select></select>', null, 7],
            ['<select name="test"></select>', 'test', null],
            ['<select name="test[]"></select>', 'test[]', null],
            [
                '<input type="hidden" name="test" value="7">' . "\n" .
                '<select name="test"></select>',
                'test',
                7,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n" .
                '<select name="test[]"></select>',
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
            Select::tag()
                ->name($name)
                ->unselectValue($value)
                ->render()
        );
    }

    public function testUnselectValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7" disabled>' . "\n" .
            '<select name="test" disabled></select>',
            Select::tag()
                ->name('test')
                ->unselectValue(7)
                ->disabled()
                ->render()
        );
    }

    public function testUnselectValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7" form="post">' . "\n" .
            '<select name="test" form="post"></select>',
            Select::tag()
                ->name('test')
                ->unselectValue(7)
                ->form('post')
                ->render()
        );
    }

    public function testUnselectValueMultiple(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7">' . "\n" .
            '<select name="test[]" multiple></select>',
            Select::tag()
                ->name('test')
                ->unselectValue(7)
                ->multiple()
                ->render()
        );
    }

    public function testOnChange(): void
    {
        $baseSelect = Select::tag();

        $select = Select::tag()->onChange('console.log(42)');

        $this->assertNotSame($baseSelect, $select);
        $this->assertSame(
            '<select onchange="console.log(42)"></select>',
            (string) $select,
        );
    }

    public function testImmutability(): void
    {
        $select = Select::tag();
        $this->assertNotSame($select, $select->name(''));
        $this->assertNotSame($select, $select->value());
        $this->assertNotSame($select, $select->values([]));
        $this->assertNotSame($select, $select->form(null));
        $this->assertNotSame($select, $select->items());
        $this->assertNotSame($select, $select->options());
        $this->assertNotSame($select, $select->optionsData([]));
        $this->assertNotSame($select, $select->prompt(''));
        $this->assertNotSame($select, $select->promptOption(Option::tag()));
        $this->assertNotSame($select, $select->disabled());
        $this->assertNotSame($select, $select->multiple());
        $this->assertNotSame($select, $select->required());
        $this->assertNotSame($select, $select->size(0));
        $this->assertNotSame($select, $select->unselectValue(null));
    }
}
