<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Progress;

final class ProgressTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<progress class="red">Hello</progress>',
            (string) (new Progress())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<progress max="100">Hello</progress>',
            (string) (new Progress())->max(100)->content('Hello'),
        );
    }

    public function testValue(): void
    {
        $this->assertSame(
            '<progress value="50">Hello</progress>',
            (string) (new Progress())->value(50)->content('Hello'),
        );
    }
}
