<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Caption;
use Yiisoft\Html\Tag\Col;
use Yiisoft\Html\Tag\Colgroup;
use Yiisoft\Html\Tag\Table;
use Yiisoft\Html\Tag\Tbody;
use Yiisoft\Html\Tag\Tfoot;
use Yiisoft\Html\Tag\Thead;
use Yiisoft\Html\Tag\Tr;

class TableTest extends TestCase
{
    public function testEmpty(): void
    {
        $this->assertSame('<table></table>', Table::tag()->render());
    }

    public static function dataCaption(): array
    {
        return [
            ['<table></table>', null],
            ["<table>\n<caption>Hello</caption>\n</table>", Caption::tag()->content('Hello')],
        ];
    }

    #[DataProvider('dataCaption')]
    public function testCaption(string $expected, ?Caption $caption): void
    {
        $this->assertSame($expected, Table::tag()
            ->caption($caption)
            ->render());
    }

    public function testCaptionString(): void
    {
        $this->assertSame(
            "<table>\n<caption>Hello</caption>\n</table>",
            Table::tag()
                ->captionString('Hello')
                ->render()
        );
    }

    public function testCaptionStringWithEncode(): void
    {
        $this->assertSame(
            "<table>\n<caption>&lt;b&gt;Hello&lt;/b&gt;</caption>\n</table>",
            Table::tag()
                ->captionString('<b>Hello</b>')
                ->render()
        );
    }

    public function testCaptionStringWithoutEncode(): void
    {
        $this->assertSame(
            "<table>\n<caption><b>Hello</b></caption>\n</table>",
            Table::tag()
                ->captionString('<b>Hello</b>', false)
                ->render()
        );
    }

    public function testColumnGroups(): void
    {
        $tag = Table::tag()->columnGroups(
            Colgroup::tag()->columns(
                Col::tag(),
                Col::tag()->span(2),
            ),
            Colgroup::tag()->span(4),
        );

        $this->assertSame(
            '<table>' . "\n" .
            '<colgroup>' . "\n" .
            '<col>' . "\n" .
            '<col span="2">' . "\n" .
            '</colgroup>' . "\n" .
            '<colgroup span="4"></colgroup>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testAddColumnGroups(): void
    {
        $tag = Table::tag()
            ->columnGroups(
                Colgroup::tag()->columns(
                    Col::tag(),
                    Col::tag()->span(2),
                ),
            )
            ->addColumnGroups(
                Colgroup::tag()->span(4),
                Colgroup::tag()->span(5),
            );

        $this->assertSame(
            '<table>' . "\n" .
            '<colgroup>' . "\n" .
            '<col>' . "\n" .
            '<col span="2">' . "\n" .
            '</colgroup>' . "\n" .
            '<colgroup span="4"></colgroup>' . "\n" .
            '<colgroup span="5"></colgroup>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testColumns(): void
    {
        $tag = Table::tag()->columns(
            Col::tag(),
            Col::tag()->span(2),
        );

        $this->assertSame(
            '<table>' . "\n" .
            '<col>' . "\n" .
            '<col span="2">' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testAddColumns(): void
    {
        $tag = Table::tag()
            ->columns(
                Col::tag(),
                Col::tag()->span(2),
            )
            ->addColumns(
                Col::tag()->span(3),
                Col::tag()->span(4),
            );

        $this->assertSame(
            '<table>' . "\n" .
            '<col>' . "\n" .
            '<col span="2">' . "\n" .
            '<col span="3">' . "\n" .
            '<col span="4">' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public static function dataHeader(): array
    {
        return [
            ['<table></table>', null],
            ["<table>\n<thead></thead>\n</table>", Thead::tag()],
        ];
    }

    #[DataProvider('dataHeader')]
    public function testHeader(string $expected, ?Thead $header): void
    {
        $this->assertSame($expected, Table::tag()
            ->header($header)
            ->render());
    }

    public function testBody(): void
    {
        $tag = Table::tag()->body(
            Tbody::tag(),
            Tbody::tag()->class('red'),
        );

        $this->assertSame(
            '<table>' . "\n" .
            '<tbody></tbody>' . "\n" .
            '<tbody class="red"></tbody>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testAddBody(): void
    {
        $tag = Table::tag()
            ->body(
                Tbody::tag(),
            )
            ->addBody(
                Tbody::tag()->class('red'),
                Tbody::tag()->class('green'),
            );

        $this->assertSame(
            '<table>' . "\n" .
            '<tbody></tbody>' . "\n" .
            '<tbody class="red"></tbody>' . "\n" .
            '<tbody class="green"></tbody>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testRows(): void
    {
        $tag = Table::tag()->rows(
            Tr::tag()->dataStrings(['A', 'B']),
            Tr::tag()->dataStrings(['C', 'D']),
        );

        $this->assertSame(
            '<table>' . "\n" .
            '<tr>' . "\n" .
            '<td>A</td>' . "\n" .
            '<td>B</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>C</td>' . "\n" .
            '<td>D</td>' . "\n" .
            '</tr>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public function testAddRows(): void
    {
        $tag = Table::tag()
            ->rows(
                Tr::tag()->dataStrings(['A', 'B']),
            )
            ->addRows(
                Tr::tag()->dataStrings(['C', 'D']),
                Tr::tag()->dataStrings(['E', 'F']),
            );

        $this->assertSame(
            '<table>' . "\n" .
            '<tr>' . "\n" .
            '<td>A</td>' . "\n" .
            '<td>B</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>C</td>' . "\n" .
            '<td>D</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>E</td>' . "\n" .
            '<td>F</td>' . "\n" .
            '</tr>' . "\n" .
            '</table>',
            $tag->render()
        );
    }

    public static function dataFooter(): array
    {
        return [
            ['<table></table>', null],
            ["<table>\n<tfoot></tfoot>\n</table>", Tfoot::tag()],
        ];
    }

    #[DataProvider('dataFooter')]
    public function testFooter(string $expected, ?Tfoot $footer): void
    {
        $this->assertSame($expected, Table::tag()
            ->footer($footer)
            ->render());
    }

    public static function dataItemsOrder(): array
    {
        return [
            [
                '<table>' . "\n" .
                '<caption>Caption of Table</caption>' . "\n" .
                '<colgroup></colgroup>' . "\n" .
                '<thead></thead>' . "\n" .
                '<tbody></tbody>' . "\n" .
                '<tfoot></tfoot>' . "\n" .
                '</table>',
                Table::tag()
                    ->captionString('Caption of Table')
                    ->columnGroups(Colgroup::tag())
                    ->header(Thead::tag())
                    ->body(Tbody::tag())
                    ->footer(Tfoot::tag()),
            ],
            [
                '<table>' . "\n" .
                '<caption>Caption of Table</caption>' . "\n" .
                '<col>' . "\n" .
                '<thead></thead>' . "\n" .
                '<tr></tr>' . "\n" .
                '<tfoot></tfoot>' . "\n" .
                '</table>',
                Table::tag()
                    ->captionString('Caption of Table')
                    ->columns(Col::tag())
                    ->header(Thead::tag())
                    ->rows(Tr::tag())
                    ->footer(Tfoot::tag()),
            ],
        ];
    }

    #[DataProvider('dataItemsOrder')]
    public function testItemsOrder(string $expected, Table $tag): void
    {
        $this->assertSame($expected, $tag->render());
    }

    public function testImmutability(): void
    {
        $tag = Table::tag();
        $this->assertNotSame($tag, $tag->caption(null));
        $this->assertNotSame($tag, $tag->captionString(''));
        $this->assertNotSame($tag, $tag->columnGroups());
        $this->assertNotSame($tag, $tag->addColumnGroups());
        $this->assertNotSame($tag, $tag->columns());
        $this->assertNotSame($tag, $tag->addColumns());
        $this->assertNotSame($tag, $tag->header(null));
        $this->assertNotSame($tag, $tag->body());
        $this->assertNotSame($tag, $tag->addBody());
        $this->assertNotSame($tag, $tag->rows());
        $this->assertNotSame($tag, $tag->addRows());
        $this->assertNotSame($tag, $tag->footer(null));
    }
}
