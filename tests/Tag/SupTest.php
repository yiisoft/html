<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Sup;

final class SupTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<sup class="red">Hello</sup>',
            (string) (new Sup())
                ->class('red')
                ->content('Hello'),
        );
    }
}
