<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Bdo;

final class BdoTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<bdo class="red">Hello</bdo>',
            (string) (new Bdo())
                ->class('red')
                ->content('Hello'),
        );
    }
}
