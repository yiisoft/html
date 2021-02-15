<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;

final class OptgroupTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<optgroup label="Count">' . "\n" .
            '<option value="1">One</option>' . "\n" .
            '<option value="2">Two</option>' . "\n" .
            '</optgroup>',
            (string)Optgroup::tag()
                ->options(
                    Option::tag()->value('1')->content('One'),
                    Option::tag()->value('2')->content('Two'),
                )
                ->label('Count')
        );
    }

    public function testOptions(): void
    {
        $this->assertSame(
            "<optgroup>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</optgroup>",
            (string)Optgroup::tag()
                ->options(
                    Option::tag()->value('1')->content('One'),
                    Option::tag()->value('2')->content('Two'),
                )
        );
    }

    public function testOptionsData(): void
    {
        $this->assertSame(
            "<optgroup>\n<option value=\"1\">One</option>\n<option value=\"2\">Two</option>\n</optgroup>",
            (string)Optgroup::tag()->optionsData(['1' => 'One', '2' => 'Two'])
        );
    }

    public function testOptionsDataEncode(): void
    {
        $this->assertSame(
            "<optgroup>\n<option value=\"1\">&lt;b&gt;One&lt;/b&gt;</option>\n</optgroup>",
            (string)Optgroup::tag()->optionsData(['1' => '<b>One</b>'])
        );
    }

    public function testOptionsDataWithoutEncode(): void
    {
        $this->assertSame(
            "<optgroup>\n<option value=\"1\"><b>One</b></option>\n</optgroup>",
            (string)Optgroup::tag()->optionsData(['1' => '<b>One</b>'], false)
        );
    }

    public function dataLabel(): array
    {
        return [
            ['<optgroup></optgroup>', null],
            ['<optgroup label="Name"></optgroup>', 'Name'],
        ];
    }

    /**
     * @dataProvider dataLabel
     */
    public function testLabel(string $expected, ?string $label): void
    {
        $this->assertSame($expected, (string)Optgroup::tag()->label($label));
    }

    public function testSeparator(): void
    {
        self::assertSame(
            '<optgroup>' . "\r" .
            '<option value="1">One</option>' . "\r" .
            '<option value="2">Two</option>' . "\r" .
            '</optgroup>',
            (string)Optgroup::tag()
                ->optionsData(['1' => 'One', '2' => 'Two'])
                ->separator("\r")
        );
    }

    public function testWithoutSeparator(): void
    {
        self::assertSame(
            '<optgroup>' .
            '<option value="1">One</option>' .
            '<option value="2">Two</option>' .
            '</optgroup>',
            (string)Optgroup::tag()
                ->optionsData(['1' => 'One', '2' => 'Two'])
                ->withoutSeparator()
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<optgroup disabled></optgroup>', (string)Optgroup::tag()->disabled());
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()->disabled(false));
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()->disabled(true)->disabled(false));
    }

    public function dataSelection(): array
    {
        return [
            ['<optgroup></optgroup>', [], []],
            ['<optgroup></optgroup>', [], [42]],
            [
                '<optgroup><option value="1"></option><option value="2"></option></optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')->selected()],
                [],
            ],
            [
                '<optgroup><option value="1"></option><option value="2"></option></optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [7],
            ],
            [
                '<optgroup><option value="1" selected></option><option value="2"></option></optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1],
            ],
            [
                '<optgroup><option value="1"></option><option value="2" selected></option></optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                ['2'],
            ],
            [
                '<optgroup><option value="1" selected></option><option value="2" selected></option></optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1, 2],
            ],
        ];
    }

    /**
     * @dataProvider dataSelection
     */
    public function testSelection(string $expected, array $options, array $selection): void
    {
        $this->assertSame(
            $expected,
            (string)Optgroup::tag()->options(...$options)->selection(...$selection)->separator(''),
        );
    }

    public function testImmutability(): void
    {
        $optgroup = Optgroup::tag();
        self::assertNotSame($optgroup, $optgroup->options());
        self::assertNotSame($optgroup, $optgroup->optionsData([]));
        self::assertNotSame($optgroup, $optgroup->label(null));
        self::assertNotSame($optgroup, $optgroup->separator(''));
        self::assertNotSame($optgroup, $optgroup->withoutSeparator());
        self::assertNotSame($optgroup, $optgroup->disabled());
        self::assertNotSame($optgroup, $optgroup->selection());
    }
}
