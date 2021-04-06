<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Br;

final class BrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<br>',
            (string)Br::tag()
        );
    }
}
