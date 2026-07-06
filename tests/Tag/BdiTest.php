<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Bdi;

final class BdiTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<bdi class="red">Hello</bdi>',
            (string) (new Bdi())
                ->class('red')
                ->content('Hello'),
        );
    }
}
