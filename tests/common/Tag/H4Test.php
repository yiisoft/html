<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H4;

final class H4Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h4 class="red">Hello</h4>',
            (string) H4::tag()->class('red')->content('Hello')
        );
    }
}
