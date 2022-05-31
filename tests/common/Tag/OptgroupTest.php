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
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Option::tag()
                        ->value('2')
                        ->content('Two'),
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

    public function testDisabled(): void
    {
        $this->assertSame('<optgroup disabled></optgroup>', (string)Optgroup::tag()->disabled());
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()->disabled(false));
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()
            ->disabled(true)
            ->disabled(false));
    }

    public function dataSelection(): array
    {
        return [
            ['<optgroup></optgroup>', [], []],
            ['<optgroup></optgroup>', [], [42]],
            [
                '<optgroup>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</optgroup>',
                [Option::tag()->value('1'), Option::tag()
                    ->value('2')
                    ->selected()],
                [],
            ],
            [
                '<optgroup>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [7],
            ],
            [
                '<optgroup>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2"></option>' . "\n" .
                '</optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                [1],
            ],
            [
                '<optgroup>' . "\n" .
                '<option value="1"></option>' . "\n" .
                '<option value="2" selected></option>' . "\n" .
                '</optgroup>',
                [Option::tag()->value('1'), Option::tag()->value('2')],
                ['2'],
            ],
            [
                '<optgroup>' . "\n" .
                '<option value="1" selected></option>' . "\n" .
                '<option value="2" selected></option>' . "\n" .
                '</optgroup>',
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
            (string)Optgroup::tag()
                ->options(...$options)
                ->selection(...$selection),
        );
    }

    public function testImmutability(): void
    {
        $optgroup = Optgroup::tag();
        $this->assertNotSame($optgroup, $optgroup->options());
        $this->assertNotSame($optgroup, $optgroup->optionsData([]));
        $this->assertNotSame($optgroup, $optgroup->label(null));
        $this->assertNotSame($optgroup, $optgroup->disabled());
        $this->assertNotSame($optgroup, $optgroup->selection());
    }
}
