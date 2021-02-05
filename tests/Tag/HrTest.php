<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Hr;
use Yiisoft\Html\Tests\TestCase;

final class HrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<hr id="main">',
            (string)Hr::tag()->id('main')
        );
    }
}
