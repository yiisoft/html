<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestBooleanInputTag;

final class BooleanInputTagTest extends TestCase
{
    public function testChecked(): void
    {
        self::assertSame('<input type="test" checked>', (string)TestBooleanInputTag::tag()->checked());
        self::assertSame('<input type="test">', (string)TestBooleanInputTag::tag()->checked(false));
        self::assertSame('<input type="test">', (string)TestBooleanInputTag::tag()->checked(true)->checked(false));
    }

    public function dataUnselectValue(): array
    {
        return [
            ['<input type="test">', null, null],
            ['<input type="test">', null, 7],
            ['<input type="test" name="color">', 'color', null],
            ['<input type="test" name="color[]">', 'color[]', null],
            [
                '<input type="hidden" name="color" value="7"><input type="test" name="color">',
                'color',
                7
            ],
            [
                '<input type="hidden" name="color" value="7"><input type="test" name="color[]">',
                'color[]',
                7
            ],
        ];
    }

    /**
     * @dataProvider dataUnselectValue
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public function testUncheckValue(string $expected, ?string $name, $value): void
    {
        self::assertSame(
            $expected,
            TestBooleanInputTag::tag()->name($name)->uncheckValue($value)->render()
        );
    }

    public function testUncheckValueDisabled(): void
    {
        self::assertSame(
            '<input type="hidden" name="color" value="7" disabled>' .
            '<input type="test" name="color" disabled>',
            TestBooleanInputTag::tag()->name('color')->uncheckValue(7)->disabled()->render()
        );
    }

    public function testUncheckValueForm(): void
    {
        self::assertSame(
            '<input type="hidden" name="color" value="7" form="post">' .
            '<input type="test" name="color" form="post">',
            TestBooleanInputTag::tag()->name('color')->uncheckValue(7)->form('post')->render()
        );
    }

    public function testImmutability(): void
    {
        $input = TestBooleanInputTag::tag();
        self::assertNotSame($input, $input->checked());
        self::assertNotSame($input, $input->uncheckValue(null));
    }
}
