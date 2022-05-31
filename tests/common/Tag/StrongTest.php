<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Strong;

final class StrongTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<strong class="red">Hello</strong>',
            (string)Strong::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
