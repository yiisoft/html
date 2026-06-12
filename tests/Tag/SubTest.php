<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Sub;

final class SubTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<sub class="red">Hello</sub>',
            (string) (new Sub())
                ->class('red')
                ->content('Hello'),
        );
    }
}
