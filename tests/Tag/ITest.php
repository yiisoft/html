<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\I;

final class ITest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<i class="red">Hello</i>',
            (string) I::tag()
                ->class('red')
                ->content('Hello'),
        );
    }
}
