<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Dfn;

final class DfnTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<dfn class="red">Hello</dfn>',
            (string) (new Dfn())
                ->class('red')
                ->content('Hello'),
        );
    }
}
