<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Mark;

final class MarkTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<mark class="red">Hello</mark>',
            (string) (new Mark())
                ->class('red')
                ->content('Hello'),
        );
    }
}
