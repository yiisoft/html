<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Tbody;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Tr;

final class TbodyTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<tbody class="gray">' . "\n" .
            '<tr>' . "\n" .
            '<td>A</td>' . "\n" .
            '<td>B</td>' . "\n" .
            '</tr>' . "\n" .
            '<tr>' . "\n" .
            '<td>C</td>' . "\n" .
            '<td>D</td>' . "\n" .
            '</tr>' . "\n" .
            '</tbody>',
            Tbody::tag()
                ->class('gray')
                ->rows(
                    Tr::tag()->dataStrings(['A', 'B']),
                    Tr::tag()->dataStrings(['C', 'D']),
                )
                ->render()
        );
    }
}
