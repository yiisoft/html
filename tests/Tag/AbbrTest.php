<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Abbr;

final class AbbrTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<abbr class="red">Hello</abbr>',
            (string) (new Abbr())
                ->class('red')
                ->content('Hello'),
        );
    }
}
