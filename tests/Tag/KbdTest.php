<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Kbd;

final class KbdTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<kbd class="red">Hello</kbd>',
            (string) (new Kbd())
                ->class('red')
                ->content('Hello'),
        );
    }
}
