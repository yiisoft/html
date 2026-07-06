<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Output;

final class OutputTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<output class="red">Hello</output>',
            (string) (new Output())
                ->class('red')
                ->content('Hello'),
        );
    }
}
