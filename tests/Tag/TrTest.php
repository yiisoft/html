<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Td;
use Yiisoft\Html\Tag\Th;
use Yiisoft\Html\Tag\Tr;

class TrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<tr class="row">' . "\n"
            . '<td class="cell">One</td>' . "\n"
            . '<td class="cell">Two</td>' . "\n"
            . '<td class="cell">Three</td>' . "\n"
            . '</tr>',
            new Tr()
                ->class('row')
                ->dataStrings(['One', 'Two', 'Three'], ['class' => 'cell'])
                ->render(),
        );
    }

    public function testCells(): void
    {
        $tr = (new Tr())->cells(
            (new Th())->content('A'),
            (new Td())->content('B'),
        );

        $this->assertSame("<tr>\n<th>A</th>\n<td>B</td>\n</tr>", (string) $tr);
    }

    public function testAddCells(): void
    {
        $tr = new Tr()
            ->cells(new Td()->content('A'))
            ->addCells(new Td()->content('B'));

        $this->assertSame("<tr>\n<td>A</td>\n<td>B</td>\n</tr>", (string) $tr);
    }

    public function testDataStrings(): void
    {
        $tr = new Tr()
            ->dataStrings(['A', 'B']);

        $this->assertSame("<tr>\n<td>A</td>\n<td>B</td>\n</tr>", (string) $tr);
    }

    public function testDataStringsAttributes(): void
    {
        $tr = new Tr()
            ->dataStrings(['A', 'B'], ['class' => 'red']);

        $this->assertSame("<tr>\n<td class=\"red\">A</td>\n<td class=\"red\">B</td>\n</tr>", (string) $tr);
    }

    public function testDataStringsEncode(): void
    {
        $tr = new Tr()
            ->dataStrings(['A > B']);

        $this->assertSame("<tr>\n<td>A &gt; B</td>\n</tr>", (string) $tr);
    }

    public function testDataStringsWithoutEncode(): void
    {
        $tr = new Tr()
            ->dataStrings(['<b>A</b>'], [], false);

        $this->assertSame("<tr>\n<td><b>A</b></td>\n</tr>", (string) $tr);
    }

    public function testAddDataStrings(): void
    {
        $tr = new Tr()
            ->dataStrings(['A'])
            ->addDataStrings(['B', 'C']);

        $this->assertSame("<tr>\n<td>A</td>\n<td>B</td>\n<td>C</td>\n</tr>", (string) $tr);
    }

    public function testAddDataStringsAttributes(): void
    {
        $tr = new Tr()
            ->dataStrings(['A'])
            ->addDataStrings(['B'], ['class' => 'red']);

        $this->assertSame("<tr>\n<td>A</td>\n<td class=\"red\">B</td>\n</tr>", (string) $tr);
    }

    public function testAddDataStringsEncode(): void
    {
        $tr = new Tr()
            ->dataStrings(['A'])
            ->addDataStrings(['B > 1']);

        $this->assertSame("<tr>\n<td>A</td>\n<td>B &gt; 1</td>\n</tr>", (string) $tr);
    }

    public function testAddDataStringsWithoutEncode(): void
    {
        $tr = new Tr()
            ->dataStrings(['A'])
            ->addDataStrings(['<b>B</b>'], [], false);

        $this->assertSame("<tr>\n<td>A</td>\n<td><b>B</b></td>\n</tr>", (string) $tr);
    }

    public function testHeaderStrings(): void
    {
        $tr = new Tr()
            ->headerStrings(['A', 'B']);

        $this->assertSame("<tr>\n<th>A</th>\n<th>B</th>\n</tr>", (string) $tr);
    }

    public function testHeaderStringsAttributes(): void
    {
        $tr = new Tr()
            ->headerStrings(['A', 'B'], ['class' => 'red']);

        $this->assertSame("<tr>\n<th class=\"red\">A</th>\n<th class=\"red\">B</th>\n</tr>", (string) $tr);
    }

    public function testHeaderStringsEncode(): void
    {
        $tr = new Tr()
            ->headerStrings(['A > B']);

        $this->assertSame("<tr>\n<th>A &gt; B</th>\n</tr>", (string) $tr);
    }

    public function testHeaderStringsWithoutEncode(): void
    {
        $tr = new Tr()
            ->headerStrings(['<b>A</b>'], [], false);

        $this->assertSame("<tr>\n<th><b>A</b></th>\n</tr>", (string) $tr);
    }

    public function testAddHeaderStrings(): void
    {
        $tr = new Tr()
            ->headerStrings(['A'])
            ->addHeaderStrings(['B', 'C']);

        $this->assertSame("<tr>\n<th>A</th>\n<th>B</th>\n<th>C</th>\n</tr>", (string) $tr);
    }

    public function testAddHeaderStringsAttributes(): void
    {
        $tr = new Tr()
            ->headerStrings(['A'])
            ->addHeaderStrings(['B'], ['class' => 'red']);

        $this->assertSame("<tr>\n<th>A</th>\n<th class=\"red\">B</th>\n</tr>", (string) $tr);
    }

    public function testAddHeaderStringsEncode(): void
    {
        $tr = new Tr()
            ->headerStrings(['A'])
            ->addHeaderStrings(['B > 1']);

        $this->assertSame("<tr>\n<th>A</th>\n<th>B &gt; 1</th>\n</tr>", (string) $tr);
    }

    public function testAddHeaderStringsWithoutEncode(): void
    {
        $tr = new Tr()
            ->headerStrings(['A'])
            ->addHeaderStrings(['<b>B</b>'], [], false);

        $this->assertSame("<tr>\n<th>A</th>\n<th><b>B</b></th>\n</tr>", (string) $tr);
    }

    public function testImmutability(): void
    {
        $tr = new Tr();
        $this->assertNotSame($tr, $tr->cells());
        $this->assertNotSame($tr, $tr->addCells());
        $this->assertNotSame($tr, $tr->dataStrings([]));
        $this->assertNotSame($tr, $tr->addDataStrings([]));
        $this->assertNotSame($tr, $tr->headerStrings([]));
        $this->assertNotSame($tr, $tr->addHeaderStrings([]));
    }
}
