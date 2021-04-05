<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Tfoot;
use Yiisoft\Html\Tag\Tr;

final class TfootTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<tfoot class="gray">' . "\n" .
            '<tr>' . "\n" .
            '<td>A</td>' . "\n" .
            '<td>B</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>C</td>' . "\n" .
            '<td>D</td>' . "\n" .
            '</tr>' . "\n" .
            '</tfoot>',
            Tfoot::tag()
                ->class('gray')
                ->rows(
                    Tr::tag()->dataStrings(['A', 'B']),
                    Tr::tag()->dataStrings(['C', 'D']),
                )
                ->render()
        );
    }
}
