<?php

declare(strict_types=1);

namespace Yiisoft\Html\TestsPhp81\Widget\RadioList;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\TestsPhp81\Support\IntegerEnum;
use Yiisoft\Html\TestsPhp81\Support\StringEnum;
use Yiisoft\Html\Widget\RadioList\RadioList;

final class RadioLIstTest extends TestCase
{
    public static function dataValue(): iterable
    {
        return [
            ["<div>\n</div>", [], StringEnum::A],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="one"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="two"> Two</label>' . "\n" .
                '</div>',
                [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
                StringEnum::C,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="one" checked> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="two"> Two</label>' . "\n" .
                '</div>',
                [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
                StringEnum::A,
            ],
            ["<div>\n</div>", [], IntegerEnum::A],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
                IntegerEnum::C,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1" checked> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
                IntegerEnum::A,
            ],
        ];
    }

    /**
     * @dataProvider dataValue
     */
    public function testValue(string $expected, array $items, $value): void
    {
        $this->assertSame(
            $expected,
            RadioList::create('test')->items($items)->value($value)->render(),
        );
    }
}
