<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Figcaption;

final class FigcaptionTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<figcaption class="red">Hello</figcaption>',
            (string) (new Figcaption())
                ->class('red')
                ->content('Hello'),
        );
    }
}
