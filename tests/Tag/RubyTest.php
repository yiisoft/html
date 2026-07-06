<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Ruby;

final class RubyTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<ruby class="red">Hello</ruby>',
            (string) (new Ruby())
                ->class('red')
                ->content('Hello'),
        );
    }
}
