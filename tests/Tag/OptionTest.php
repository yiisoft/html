<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Option;

final class OptionTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<option value="1">One</option>',
            (string) new Option()
                ->value('1')
                ->content('One'),
        );
    }

    public static function dataValue(): array
    {
        return [
            ['<option></option>', null],
            ['<option value="7"></option>', '7'],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, ?string $value): void
    {
        $this->assertSame($expected, (string) (new Option())->value($value));
    }

    public function testSelected(): void
    {
        $this->assertSame('<option selected></option>', (string) (new Option())->selected());
        $this->assertSame('<option></option>', (string) (new Option())->selected(false));
        $this->assertSame('<option></option>', (string) (new Option())->selected(true)->selected(false));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<option disabled></option>', (string) (new Option())->disabled());
        $this->assertSame('<option></option>', (string) (new Option())->disabled(false));
        $this->assertSame('<option></option>', (string) new Option()
            ->disabled(true)
            ->disabled(false));
    }

    public static function dataGetValue(): array
    {
        return [
            [null, new Option()],
            [null, (new Option())->value(null)],
            ['', (new Option())->value('')],
            ['one', (new Option())->value('one')],
        ];
    }

    #[DataProvider('dataGetValue')]
    public function testGetValue(?string $expected, Option $tag): void
    {
        $this->assertSame($expected, $tag->getValue());
    }

    public function testImmutability(): void
    {
        $option = new Option();
        $this->assertNotSame($option, $option->value(null));
        $this->assertNotSame($option, $option->selected());
        $this->assertNotSame($option, $option->disabled());
    }
}
