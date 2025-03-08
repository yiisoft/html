<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Pre;

final class PreTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<pre class="red">Hello</pre>',
            (string) Pre::tag()
                ->class('red')
                ->content('Hello')
        );
    }
}
