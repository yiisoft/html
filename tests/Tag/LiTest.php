<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;

final class LiTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<li class="red">Hello</li>',
            (string)Li::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
