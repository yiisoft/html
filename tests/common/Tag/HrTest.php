<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Hr;

final class HrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<hr>',
            (string)Hr::tag()
        );
    }
}
