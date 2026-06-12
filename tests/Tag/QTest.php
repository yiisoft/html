<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Q;

final class QTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<q class="red">Hello</q>',
            (string) (new Q())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testCite(): void
    {
        $this->assertSame(
            '<q cite="https://example.com">Hello</q>',
            (string) (new Q())
                ->cite('https://example.com')
                ->content('Hello'),
        );
    }

    public function testImmutability(): void
    {
        $tag = new Q();
        $this->assertNotSame($tag, $tag->cite(null));
    }
}
