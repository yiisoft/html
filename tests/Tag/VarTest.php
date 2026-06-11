<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Var_;

final class VarTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<var class="red">Hello</var>',
            (string) (new Var_())
                ->class('red')
                ->content('Hello'),
        );
    }
}
