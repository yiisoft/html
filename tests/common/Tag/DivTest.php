<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Div;

final class DivTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<div class="red">Hello</div>',
            (string)Div::tag()
                ->replaceClass('red')
                ->content('Hello')
        );
    }
}
