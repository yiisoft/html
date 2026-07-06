<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Rp;

final class RpTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<rp class="red">Hello</rp>',
            (string) (new Rp())
                ->class('red')
                ->content('Hello'),
        );
    }
}
