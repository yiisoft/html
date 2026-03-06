<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Code;

final class CodeTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<code class="red">Hello</code>',
            (string) (new Code())
                ->class('red')
                ->content('Hello'),
        );
    }
}
