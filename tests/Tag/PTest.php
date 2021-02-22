<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\P;

final class PTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<p class="red">Hello</p>',
            (string)P::tag()->class('red')->content('Hello')
        );
    }
}
