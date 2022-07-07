<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Span;

final class SpanTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<span class="red">Hello</span>',
            (string)Span::tag()
                ->replaceClass('red')
                ->content('Hello')
        );
    }
}
