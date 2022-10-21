<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H1;

final class H1Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h1 class="red">Hello</h1>',
            (string) H1::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
