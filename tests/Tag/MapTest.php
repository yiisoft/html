<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Map;

final class MapTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<map class="red">Hello</map>',
            (string) (new Map())
                ->class('red')
                ->content('Hello'),
        );
    }
}
