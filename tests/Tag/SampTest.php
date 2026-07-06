<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Samp;

final class SampTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<samp class="red">Hello</samp>',
            (string) (new Samp())
                ->class('red')
                ->content('Hello'),
        );
    }
}
