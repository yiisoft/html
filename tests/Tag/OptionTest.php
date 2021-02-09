<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Option;

final class OptionTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<option value="1">One</option>',
            (string)Option::tag()->value('1')->content('One')
        );
    }

    public function dataValue(): array
    {
        return [
            ['<option></option>', null],
            ['<option value="7"></option>', '7'],
        ];
    }

    /**
     * @dataProvider dataValue
     */
    public function testValue(string $expected, ?string $value): void
    {
        $this->assertSame($expected, (string)Option::tag()->value($value));
    }

    public function testSelected(): void
    {
        $this->assertSame('<option selected></option>', (string)Option::tag()->selected());
        $this->assertSame('<option></option>', (string)Option::tag()->selected(false));
        $this->assertSame('<option></option>', (string)Option::tag()->selected(true)->selected(false));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<option disabled></option>', (string)Option::tag()->disabled());
        $this->assertSame('<option></option>', (string)Option::tag()->disabled(false));
        $this->assertSame('<option></option>', (string)Option::tag()->disabled(true)->disabled(false));
    }

    public function dataGetValue(): array
    {
        return [
            [null, Option::tag()],
            [null, Option::tag()->value(null)],
            ['', Option::tag()->value('')],
            ['one', Option::tag()->value('one')],
        ];
    }

    /**
     * @dataProvider dataGetValue
     */
    public function testGetValue(?string $expected, Option $tag): void
    {
        $this->assertSame($expected, $tag->getValue());
    }

    public function testImmutability(): void
    {
        $option = Option::tag();
        $this->assertNotSame($option, $option->value(null));
        $this->assertNotSame($option, $option->selected());
        $this->assertNotSame($option, $option->disabled());
    }
}
