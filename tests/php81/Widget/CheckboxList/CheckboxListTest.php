<?php

declare(strict_types=1);

namespace Yiisoft\Html\TestsPhp81\Widget\CheckboxList;

use ArrayObject;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\IterableObject;
use Yiisoft\Html\TestsPhp81\Support\IntegerEnum;
use Yiisoft\Html\TestsPhp81\Support\StringEnum;
use Yiisoft\Html\Widget\CheckboxList\CheckboxList;

final class CheckboxListTest extends TestCase
{
    public static function dataValue(): iterable
    {
        yield ["<div>\n</div>", [], [StringEnum::A]];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="one"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="two"> Two</label>' . "\n" .
            '</div>',
            [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
            [StringEnum::C],
        ];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="one"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="two" checked> Two</label>' . "\n" .
            '</div>',
            [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
            [StringEnum::B],
        ];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="one"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="two" checked> Two</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="three" checked> Three</label>' . "\n" .
            '</div>',
            [StringEnum::A->value => 'One', StringEnum::B->value => 'Two', StringEnum::C->value => 'Three'],
            [StringEnum::B, StringEnum::C],
        ];
        yield ["<div>\n</div>", [], [IntegerEnum::A]];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="1"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="2"> Two</label>' . "\n" .
            '</div>',
            [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
            [IntegerEnum::C],
        ];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="1"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="2" checked> Two</label>' . "\n" .
            '</div>',
            [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
            [IntegerEnum::B],
        ];
        yield [
            '<div>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="1"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="2" checked> Two</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="3" checked> Three</label>' . "\n" .
            '</div>',
            [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two', IntegerEnum::C->value => 'Three'],
            [IntegerEnum::B, IntegerEnum::C],
        ];
    }

    /**
     * @dataProvider dataValue
     */
    public function testValue(string $expected, array $items, array $value): void
    {
        $this->assertSame(
            $expected,
            CheckboxList::create('test')
                ->items($items)
                ->value(...$value)
                ->render(),
        );
        $this->assertSame(
            $expected,
            CheckboxList::create('test')
                ->items($items)
                ->values($value)
                ->render(),
        );
        $this->assertSame(
            $expected,
            CheckboxList::create('test')
                ->items($items)
                ->values(new ArrayObject($value))
                ->render(),
        );
        $this->assertSame(
            $expected,
            CheckboxList::create('test')
                ->items($items)
                ->values(new IterableObject($value))
                ->render(),
        );
    }
}
