<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
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
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string)Select::tag()->name($name));
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
        $this->assertSame(
            $expected,
            (string)Select::tag()->items(...$items)->value(...$value)->separator(''),
        );
        $this->assertSame(
            $expected,
            (string)Select::tag()->items(...$items)->values($value)->separator(''),
        );
    }

    public function testIncorrectValues(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Select::tag()->values('42');
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
        $this->assertSame($expected, (string)Select::tag()->items(...$items)->separator(''));
    }

    public function testOptions(): void
    {
        $this->assertSame(
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
        $this->assertSame(
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
        $this->assertSame(
            $expected,
            (string)Select::tag()
                ->promptOption($option)
                ->options(Option::tag()->value('1')->content('One'))
                ->separator('')
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<select disabled></select>', (string)Select::tag()->disabled());
        $this->assertSame('<select></select>', (string)Select::tag()->disabled(false));
        $this->assertSame('<select></select>', (string)Select::tag()->disabled(true)->disabled(false));
    }

    public function testMultiple(): void
    {
        $this->assertSame('<select multiple></select>', (string)Select::tag()->multiple());
        $this->assertSame('<select></select>', (string)Select::tag()->multiple(false));
        $this->assertSame('<select></select>', (string)Select::tag()->multiple(true)->multiple(false));
    }

    public function testRequired(): void
    {
        $this->assertSame('<select required></select>', (string)Select::tag()->required());
        $this->assertSame('<select></select>', (string)Select::tag()->required(false));
        $this->assertSame('<select></select>', (string)Select::tag()->required(true)->required(false));
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
        $this->assertSame($expected, (string)Select::tag()->size($size));
    }

    public function testSeparator(): void
    {
        $this->assertSame(
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
        $this->assertNotSame($select, $select->name(''));
        $this->assertNotSame($select, $select->value());
        $this->assertNotSame($select, $select->values([]));
        $this->assertNotSame($select, $select->items());
        $this->assertNotSame($select, $select->options());
        $this->assertNotSame($select, $select->optionsData([]));
        $this->assertNotSame($select, $select->prompt(''));
        $this->assertNotSame($select, $select->promptOption(Option::tag()));
        $this->assertNotSame($select, $select->disabled());
        $this->assertNotSame($select, $select->multiple());
        $this->assertNotSame($select, $select->required());
        $this->assertNotSame($select, $select->size(0));
        $this->assertNotSame($select, $select->separator(''));
    }
}
