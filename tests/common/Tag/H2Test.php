<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H2;

final class H2Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h2 class="red">Hello</h2>',
            (string) H2::tag()
                ->replaceClass('red')
                ->content('Hello')
        );
    }
}
