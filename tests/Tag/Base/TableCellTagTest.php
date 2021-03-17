<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestTableCellTag;

final class TableCellTagTest extends TestCase
{
    public function dataColSpan(): array
    {
        return [
            ['<test></test>', null],
            ['<test colspan="12"></test>', 12],
        ];
    }

    /**
     * @dataProvider dataColSpan
     */
    public function testColSpan(string $expected, ?int $number): void
    {
        $this->assertSame($expected, (string)TestTableCellTag::tag()->colSpan($number));
    }

    public function dataRowSpan(): array
    {
        return [
            ['<test></test>', null],
            ['<test rowspan="12"></test>', 12],
        ];
    }

    /**
     * @dataProvider dataRowSpan
     */
    public function testRowSpan(string $expected, ?int $number): void
    {
        $this->assertSame($expected, (string)TestTableCellTag::tag()->rowSpan($number));
    }

    public function testImmutability(): void
    {
        $tag = TestTableCellTag::tag();
        $this->assertNotSame($tag, $tag->colSpan(null));
        $this->assertNotSame($tag, $tag->rowSpan(null));
    }
}
