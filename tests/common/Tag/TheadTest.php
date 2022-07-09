<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Thead;
use Yiisoft\Html\Tag\Tr;

final class TheadTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<thead class="gray">' . "\n" .
            '<tr>' . "\n" .
            '<td>A</td>' . "\n" .
            '<td>B</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>C</td>' . "\n" .
            '<td>D</td>' . "\n" .
            '</tr>' . "\n" .
            '</thead>',
            Thead::tag()
                ->replaceClass('gray')
                ->rows(
                    Tr::tag()->dataStrings(['A', 'B']),
                    Tr::tag()->dataStrings(['C', 'D']),
                )
                ->render()
        );
    }
}
