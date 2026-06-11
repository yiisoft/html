<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Meter;

final class MeterTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<meter class="red">Hello</meter>',
            (string) (new Meter())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testMin(): void
    {
        $this->assertSame(
            '<meter min="0">Hello</meter>',
            (string) (new Meter())->min(0)->content('Hello'),
        );
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<meter max="100">Hello</meter>',
            (string) (new Meter())->max(100)->content('Hello'),
        );
    }

    public function testValue(): void
    {
        $this->assertSame(
            '<meter value="50">Hello</meter>',
            (string) (new Meter())->value(50)->content('Hello'),
        );
    }

    public function testLow(): void
    {
        $this->assertSame(
            '<meter low="25">Hello</meter>',
            (string) (new Meter())->low(25)->content('Hello'),
        );
    }

    public function testHigh(): void
    {
        $this->assertSame(
            '<meter high="75">Hello</meter>',
            (string) (new Meter())->high(75)->content('Hello'),
        );
    }

    public function testOptimum(): void
    {
        $this->assertSame(
            '<meter optimum="50">Hello</meter>',
            (string) (new Meter())->optimum(50)->content('Hello'),
        );
    }
}
