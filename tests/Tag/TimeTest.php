<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Time;

final class TimeTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<time class="red">Hello</time>',
            (string) (new Time())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testDatetime(): void
    {
        $this->assertSame(
            '<time datetime="2024-01-01">Hello</time>',
            (string) (new Time())
                ->datetime('2024-01-01')
                ->content('Hello'),
        );
    }

    public function testImmutability(): void
    {
        $tag = new Time();
        $this->assertNotSame($tag, $tag->datetime(null));
    }
}
