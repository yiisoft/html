<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Td;

class TdTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<td>hello</td>',
            new Td()
                ->content('hello')
                ->render(),
        );
    }
}
