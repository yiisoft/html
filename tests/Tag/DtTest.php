<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Dt;

final class DtTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<dt class="red">Hello</dt>',
            (string) (new Dt())
                ->class('red')
                ->content('Hello'),
        );
    }
}
