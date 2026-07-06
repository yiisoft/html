<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Summary;

final class SummaryTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<summary class="red">Hello</summary>',
            (string) (new Summary())
                ->class('red')
                ->content('Hello'),
        );
    }
}
