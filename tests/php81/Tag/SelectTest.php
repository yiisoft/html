<?php

declare(strict_types=1);

namespace Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select;
use Yiisoft\Html\TestsPhp81\Support\IntegerEnum;
use Yiisoft\Html\TestsPhp81\Support\StringEnum;

final class SelectTest extends TestCase
{
    public function dataValue(): array
    {
        return [
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

    /**
     * @dataProvider dataValue
     */
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
}
