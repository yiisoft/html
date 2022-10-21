<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H5;

final class H5Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h5 class="red">Hello</h5>',
            (string) H5::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
