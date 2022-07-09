<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H3;

final class H3Test extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<h3 class="red">Hello</h3>',
            (string) H3::tag()
                ->replaceClass('red')
                ->content('Hello')
        );
    }
}
