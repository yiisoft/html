<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Th;
use PHPUnit\Framework\TestCase;

class ThTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<th>hello</th>',
            Th::tag()->content('hello')->render()
        );
    }
}
