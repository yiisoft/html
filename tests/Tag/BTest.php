<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\B;

final class BTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<b class="red">Hello</b>',
            (string) B::tag()
                ->class('red')
                ->content('Hello'),
        );
    }
}
