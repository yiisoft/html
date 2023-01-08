<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Small;

final class SmallTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<small class="red">Hello</small>',
            (string) Small::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
