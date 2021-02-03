<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\A;

final class ATest extends TestCase
{
    public function testBase(): void
    {
        $a = A::tag()->content('Example Link')->url('https://example.com')->id('home');
        $this->assertSame('<a id="home" href="https://example.com">Example Link</a>', (string)$a);
    }
}
