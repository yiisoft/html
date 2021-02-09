<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tests\TestCase;

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
        $this->assertSame(
            '<optgroup>' . "\r" .
            '<option value="1">One</option>' . "\r" .
            '<option value="2">Two</option>' . "\r" .
            '</optgroup>',
            (string)Optgroup::tag()
                ->optionsData(['1' => 'One', '2' => 'Two'])
                ->separator("\r")
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<optgroup disabled></optgroup>', (string)Optgroup::tag()->disabled());
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()->disabled(false));
        $this->assertSame('<optgroup></optgroup>', (string)Optgroup::tag()->disabled(true)->disabled(false));
    }

    public function testImmutability(): void
    {
        $optgroup = Optgroup::tag();
        $this->assertNotSame($optgroup, $optgroup->options());
        $this->assertNotSame($optgroup, $optgroup->optionsData([]));
        $this->assertNotSame($optgroup, $optgroup->label(null));
        $this->assertNotSame($optgroup, $optgroup->separator(''));
        $this->assertNotSame($optgroup, $optgroup->disabled());
    }
}
