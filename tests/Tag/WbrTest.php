<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Wbr;

final class WbrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<wbr>',
            (string) new Wbr(),
        );
    }
}
