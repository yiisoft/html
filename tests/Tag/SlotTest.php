<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Slot;

final class SlotTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<slot class="red">Hello</slot>',
            (string) (new Slot())
                ->class('red')
                ->content('Hello'),
        );
    }
}
