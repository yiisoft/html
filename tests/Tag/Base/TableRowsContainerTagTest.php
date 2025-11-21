<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Tr;
use Yiisoft\Html\Tests\Objects\TestTableRowsContainerTag;

final class TableRowsContainerTagTest extends TestCase
{
    public function testRows(): void
    {
        $tag = TestTableRowsContainerTag::tag()->rows(
            Tr::tag()->dataStrings(['A', 'B']),
            Tr::tag()->dataStrings(['C', 'D']),
        );

        $this->assertSame(
            '<test>' . "\n"
            . '<tr>' . "\n"
            . '<td>A</td>' . "\n"
            . '<td>B</td>' . "\n"
            . '</tr>' . "\n"
            . '<tr>' . "\n"
            . '<td>C</td>' . "\n"
            . '<td>D</td>' . "\n"
            . '</tr>' . "\n"
            . '</test>',
            $tag->render(),
        );
    }

    public function testAddRows(): void
    {
        $tag = TestTableRowsContainerTag::tag()
            ->rows(
                Tr::tag()->dataStrings(['A', 'B']),
            )
            ->addRows(
                Tr::tag()->dataStrings(['C', 'D']),
                Tr::tag()->dataStrings(['E', 'F']),
            );

        $this->assertSame(
            '<test>' . "\n"
            . '<tr>' . "\n"
            . '<td>A</td>' . "\n"
            . '<td>B</td>' . "\n"
            . '</tr>' . "\n"
            . '<tr>' . "\n"
            . '<td>C</td>' . "\n"
            . '<td>D</td>' . "\n"
            . '</tr>' . "\n"
            . '<tr>' . "\n"
            . '<td>E</td>' . "\n"
            . '<td>F</td>' . "\n"
            . '</tr>' . "\n"
            . '</test>',
            $tag->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = TestTableRowsContainerTag::tag();
        $this->assertNotSame($tag, $tag->rows());
        $this->assertNotSame($tag, $tag->addRows());
    }
}
