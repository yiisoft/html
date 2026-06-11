<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Rt;

final class RtTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<rt class="red">Hello</rt>',
            (string) (new Rt())
                ->class('red')
                ->content('Hello'),
        );
    }
}
