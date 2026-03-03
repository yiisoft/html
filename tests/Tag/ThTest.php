<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Th;

class ThTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<th>hello</th>',
            new Th()
                ->content('hello')
                ->render(),
        );
    }
}
