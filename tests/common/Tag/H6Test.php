<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H6;

final class H6Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h6 class="red">Hello</h6>',
            (string) H6::tag()->class('red')->content('Hello')
        );
    }
}
