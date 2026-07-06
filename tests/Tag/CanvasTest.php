<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Canvas;

final class CanvasTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<canvas class="red">Hello</canvas>',
            (string) (new Canvas())
                ->class('red')
                ->content('Hello'),
        );
    }
}
