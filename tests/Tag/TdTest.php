<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Td;
use PHPUnit\Framework\TestCase;

class TdTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<td>hello</td>',
            Td::tag()->content('hello')->render()
        );
    }
}
